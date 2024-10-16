package services

import (
	"gorm.io/gorm"
	"invoice-service/pkg/models"
)

type Invoice struct {
	db *gorm.DB
}

func NewInvoice(db *gorm.DB) *Invoice {
	return &Invoice{
		db: db,
	}
}

func (i *Invoice) FindAll() ([]*models.Invoice, error) {
	var invoices []*models.Invoice
	err := i.db.Preload("Items").Preload("Items.Price").Find(&invoices).Error
	return invoices, err
}

func (i *Invoice) FindById(id uint) (*models.Invoice, error) {
	var invoice models.Invoice
	err := i.db.Preload("Items").Preload("Items.Price").First(&invoice, id).Error
	return &invoice, err
}

func (i *Invoice) Create(invoice *models.Invoice) error {
	return i.db.Create(invoice).Error
}

func (i *Invoice) Update(invoice *models.Invoice) error {
	return i.db.Save(invoice).Error
}

func (i *Invoice) Delete(invoice *models.Invoice) error {
	return i.db.Delete(invoice).Error
}
