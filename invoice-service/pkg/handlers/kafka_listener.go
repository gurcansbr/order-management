package handlers

import (
	"context"
	"encoding/json"
	"fmt"
	"github.com/confluentinc/confluent-kafka-go/kafka"
	"github.com/gofiber/fiber/v2"
	"gorm.io/gorm"
	"invoice-service/pkg/models"
	"invoice-service/pkg/services"
	"log"
	"os"
	"sync"
	"time"
)

type KafkaHandler struct {
	consumer   *kafka.Consumer
	wg         sync.WaitGroup
	calculator *services.Calculator
	invoice    *services.Invoice
}

func NewKafkaHandler(brokers string, groupID string, topic string, db *gorm.DB) *KafkaHandler {
	consumer, err := kafka.NewConsumer(&kafka.ConfigMap{
		"bootstrap.servers": brokers,
		"group.id":          groupID,
		"auto.offset.reset": "earliest",
	})
	if err != nil {
		log.Fatalf("Failed to create consumer: %s\n", err)
	}

	err = consumer.SubscribeTopics([]string{topic}, nil)
	if err != nil {
		log.Fatalf("Failed to subscribe to topic: %s\n", err)
	}

	handler := &KafkaHandler{
		consumer:   consumer,
		calculator: services.NewCalculator(),
		invoice:    services.NewInvoice(db),
	}

	handler.wg.Add(1)
	go handler.startListening()

	return handler
}

func (kh *KafkaHandler) startListening() {
	defer kh.wg.Done()
	for {
		msg, err := kh.consumer.ReadMessage(-1)
		if err != nil {
			log.Printf("Error while reading message: %v\n", err)
			continue
		}
		fmt.Printf("Message received: %s\n", string(msg.Value))

		var message models.Message
		if err := json.Unmarshal(msg.Value, &message); err != nil {
			fmt.Printf("failed to unmarshal Kafka message: %w", err.Error())
			continue
		}

		invoice, err := kh.calculator.Calculate(message)
		if err != nil {
			fmt.Printf("failed to calculate Kafka message: %w", err)
			continue
		}

		fmt.Println(invoice)
		err = kh.invoice.Create(invoice)
		if err != nil {
			fmt.Printf("failed to create invoice: %w", err)
		}
	}
}

func (kh *KafkaHandler) Stop() {
	kh.consumer.Close()
	kh.wg.Wait()
}

func (kh *KafkaHandler) HandleRequest(c *fiber.Ctx) error {
	return c.SendString("Kafka Listener is running")
}

func CreateTopicIfNotExists(servers string, topic string) {
	a, err := kafka.NewAdminClient(&kafka.ConfigMap{"bootstrap.servers": servers})
	if err != nil {
		fmt.Printf("Failed to create Admin client: %s\n", err)
		os.Exit(1)
	}

	ctx, cancel := context.WithCancel(context.Background())
	defer cancel()

	maxDur, err := time.ParseDuration("60s")
	if err != nil {
		panic("ParseDuration(60s)")
	}
	results, err := a.CreateTopics(
		ctx,
		[]kafka.TopicSpecification{{
			Topic:             topic,
			NumPartitions:     1,
			ReplicationFactor: 1}},
		kafka.SetAdminOperationTimeout(maxDur))
	if err != nil {
		fmt.Printf("Failed to create topic: %v\n", err)
		os.Exit(1)
	}

	// Print results
	for _, result := range results {
		fmt.Printf("%s\n", result)
	}

	a.Close()
}
