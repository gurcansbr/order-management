package router

import (
	"github.com/gofiber/fiber/v2"
	"gorm.io/gorm"
	"invoice-service/pkg/handlers"
	"invoice-service/pkg/services"
)

type Router interface {
	SetupRoutes(r fiber.Router)
}

func SetupRoutes(a *fiber.App, db *gorm.DB) {
	api := a.Group("/api")

	handler := handlers.Invoice{
		InvoiceService: services.NewInvoice(db),
	}

	api.Get("/invoice", handler.Index)
	api.Get("/invoice/:id", handler.Get)
}
