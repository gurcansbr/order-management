# Order Management

Bu proje bir sipariş paneli ve sipariş girildikçe fatura oluşturan bir servisten oluşuyor. Sipariş paneli ile fatura servisi kafka aracılığı ile event göndererek fatura oluşturma işlemini başlatıyor

## Installation

İlk olarak dockerize projeyi ayaklandırıyoruz

```
  docker-compose up -d --build
```

Projeler ayaklandıktan sonra DB yapılandırma ayarları için "order-dashboard" container'ına girip aşağıdaki komutları sırasıyla tamamlıyoruz

```bash
  docker exec -it order-dashboard bash
```
```bash
  php artisan key:generate --ansi
  php artisan migrate
  php artisan migrate --seed
```
