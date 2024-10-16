package models

import (
	"gorm.io/gorm"
)

type Invoice struct {
	gorm.Model
	ID      uint          `json:"id"`
	OrderID uint          `json:"order_id"`
	Total   float64       `json:"total"`
	Items   []InvoiceItem `json:"items"`
}

type InvoiceItem struct {
	gorm.Model
	ID          uint    `json:"id"`
	InvoiceID   uint    `json:"invoice_id"`
	ProductID   uint    `json:"product_id"`
	Quantity    float64 `json:"quantity"`
	ProductName string  `json:"product_name"`
	Price       Price   `json:"price"`
}

type Price struct {
	gorm.Model
	ID            uint    `json:"id"`
	Base          float64 `json:"base"`
	Tax           float64 `json:"tax"`
	Discount      float64 `json:"discount"`
	InvoiceItemID uint    `json:"invoice_item_id"`
	Currency      string  `json:"currency"`
}
