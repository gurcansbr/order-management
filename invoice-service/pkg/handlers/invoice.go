package handlers

import (
	"github.com/gofiber/fiber/v2"
	"invoice-service/pkg/services"
)

type Invoice struct {
	InvoiceService *services.Invoice
}

func (i *Invoice) Index(c *fiber.Ctx) error {
	invoices, err := i.InvoiceService.FindAll()
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, err.Error())
	}

	return c.JSON(invoices)
}

func (i *Invoice) Get(c *fiber.Ctx) error {
	id, err := c.ParamsInt("id")
	if err != nil {
		return fiber.NewError(fiber.StatusBadRequest, err.Error())
	}

	invoice, err := i.InvoiceService.FindById(uint(id))
	if err != nil {
		return fiber.NewError(fiber.StatusInternalServerError, err.Error())
	}
	return c.JSON(invoice)
}
