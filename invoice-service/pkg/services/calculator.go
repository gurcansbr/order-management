package services

import (
	"invoice-service/pkg/models"
)

type Calculator struct {
}

func NewCalculator() *Calculator {
	return &Calculator{}
}

func (calculator *Calculator) Calculate(message models.Message) (*models.Invoice, error) {
	invoice := models.Invoice{
		OrderID: message.OrderID,
		Total:   0,
		Items:   []models.InvoiceItem{},
	}

	for _, item := range message.Items {
		discountedPrice := item.Price.Base * (1 - item.Price.DiscountRate)
		totalPrice := discountedPrice * (1 + item.Price.TaxRate)

		invoiceItem := models.InvoiceItem{
			ProductID:   item.ProductID,
			Quantity:    item.Quantity,
			ProductName: item.ProductName,
			Price: models.Price{
				Base:     item.Price.Base,
				Tax:      item.Price.TaxRate * item.Price.Base,
				Discount: item.Price.DiscountRate * item.Price.Base,
				Currency: item.Price.Currency,
			},
		}

		invoice.Total += totalPrice * item.Quantity
		invoice.Items = append(invoice.Items, invoiceItem)
	}

	return &invoice, nil
}
