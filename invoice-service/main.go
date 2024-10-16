package main

import (
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
	"invoice-service/pkg/models"
	"invoice-service/pkg/router"
	"log"
	"os"

	"github.com/gofiber/fiber/v2"
	"invoice-service/pkg/handlers"
)

func main() {
	app := fiber.New()

	brokers := os.Getenv("KAFKA_BROKER")
	groupID := "my-group"
	topic := os.Getenv("KAFKA_TOPIC")
	if brokers == "" {
		log.Fatal("KAFKA_BROKER is not set")
	}

	dsn := os.Getenv("DB_DSN")
	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("failed to connect to database: %v", err)
	}

	router.SetupRoutes(app, db)
	err = db.AutoMigrate(&models.Invoice{}, &models.InvoiceItem{}, &models.Price{})
	if err != nil {
		log.Fatalf("failed to connect to database: %v", err)
	}

	handlers.CreateTopicIfNotExists(brokers, topic)

	kafkaHandler := handlers.NewKafkaHandler(brokers, groupID, topic, db)

	app.Get("/kafka-health", kafkaHandler.HandleRequest)

	if err := app.Listen(":3000"); err != nil {
		panic(err)
	}

	defer kafkaHandler.Stop()
}
