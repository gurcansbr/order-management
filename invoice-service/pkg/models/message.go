package models

import (
	"encoding/json"
	"fmt"
	"reflect"
)

type Message struct {
	OrderID   uint   `json:"order_id"`
	CreatedAt string `json:"created_at"`
	Items     []Item `json:"items"`
}

type Item struct {
	ProductID   uint      `json:"product_id"`
	ProductName string    `json:"product_name"`
	Quantity    float64   `json:"quantity"`
	Price       PriceInfo `json:"price"`
}

type PriceInfo struct {
	Base         float64 `json:"base"`
	TaxRate      float64 `json:"tax_rate"`
	DiscountRate float64 `json:"discount_rate"`
	Currency     string  `json:"currency"`
}

func (p *PriceInfo) UnmarshalJSON(data []byte) error {
	var raw map[string]interface{}
	if err := json.Unmarshal(data, &raw); err != nil {
		return err
	}

	if val, ok := raw["base"]; ok {
		switch v := val.(type) {
		case float64:
			p.Base = v
		case int:
			p.Base = float64(v)
		default:
			return fmt.Errorf("unexpected type for base: %v", reflect.TypeOf(v))
		}
	}

	if val, ok := raw["tax_rate"]; ok {
		switch v := val.(type) {
		case float64:
			p.TaxRate = v
		case int:
			p.TaxRate = float64(v)
		default:
			return fmt.Errorf("unexpected type for tax_rate: %v", reflect.TypeOf(v))
		}
	}

	if val, ok := raw["discount_rate"]; ok {
		switch v := val.(type) {
		case float64:
			p.DiscountRate = v
		case int:
			p.DiscountRate = float64(v)
		default:
			return fmt.Errorf("unexpected type for discount_rate: %v", reflect.TypeOf(v))
		}
	}

	if val, ok := raw["currency"]; ok {
		if v, ok := val.(string); ok {
			p.Currency = v
		} else {
			return fmt.Errorf("unexpected type for currency: %v", reflect.TypeOf(val))
		}
	}

	return nil
}
