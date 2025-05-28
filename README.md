# Magento Dockerized Setup

Dự án này giúp bạn thiết lập môi trường phát triển Magento sử dụng Docker Compose, bao gồm PHP, MySQL, Elasticsearch và Nginx hỗ trợ SSL. Hỗ trợ cả chạy local lẫn production (Azure VM, VPS...).

## 🧱 Stack sử dụng

- Nginx (Alpine, hỗ trợ SSL)
- PHP-FPM 8.3
- MySQL 8.0
- Elasticsearch 7.16
- phpMyAdmin (tùy chọn)

## 📁 Cấu trúc thư mục

```
.
├── docker-compose.yml
├── nginx/
│   ├── Dockerfile
│   └── conf/
│       ├── nginx.conf
│       └── default.conf
├── myshop/
│   └── (Magento source code)
└── myshop.sql
```

## ⚙️ Cài đặt và khởi động

### 1. Clone repo này

```bash
https://github.com/HongTrieu04/Webmagento.git
cd magento-docker
```

### 2. Build docker

```bash
docker compose up --build
```

### 3. Vào container để cài đặt và setup magento

```bash
docker exec -it webmagento-phpfpm-1 bash

composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.4.7 magento

cd magento

bin/magento setup:install \
--backend-frontname super_admin \
--base-url=http://localhost \
--db-host=localhost \
--db-name=magentodb \
--db-user=annk \
--db-password=Andaica123. \
--admin-firstname=My \
--admin-lastname=Admin \
--admin-email=admin@otoextra.me \
--admin-user=annk \
--admin-password=ankhac0909 \
--language=en_US \
--currency=USD \
--timezone=America/Chicago \
--use-rewrites=1
--search-engine=elasticsearch7 \
--elasticsearch-host=elasticsearch \
--elasticsearch-port=9200

```
- Ở bước này ta cần chú ý setup đúng đường dẫn url (localhost hoặc url khác) và các thông tin mà mình muốn thay đổi (admin, db,...)
- Ngoai ra cần truy cập vào đây https://marketplace.magento.com/customer/accessKeys/ để lấy authentication key
- Chú ý chạy các lệnh cấp quyền nếu có lỗi khi setup: chown, chmod, find, ...
## 🚀 Cập nhật dự án vào Magento đã cài

### 1. Copy code vào container phpfpm và import db

```bash
# Copy code
docker cp /<path>/myshop/. webmagento-phpfpm-1:/var/www/html/magento/

# Copy file dump sql
docker cp /<path>/myshop.sql webmagento-db-1:/tmp/myshop.sql

# Vào container của DB để cập nhật dữ liệu từ file sql
docker exec -it webmagento-db-1 bash

mysql -u root -p magento < /tmp/myshop.sql

```

### 2. Refresh lại container phpfpm

```bash
docker exec -it webmagento-phpfpm-1 bash

cd /var/www/html/magento && \
php bin/magento setup:config:set --db-host=db --db-name=magento --db-user=magento --db-password=magento && \
php bin/magento config:set web/unsecure/base_url http://localhost/ && \
php bin/magento config:set web/secure/base_url https://localhost/ && \
php bin/magento cache:flush && \
php bin/magento indexer:reindex && \
php bin/magento deploy:mode:set developer

```
## 🌐 Truy cập

- Magento: https://localhost
- Admin: http://localhost/super_admin
      TK: annk
      MK: ankhac0909

## 🧹 Dọn dẹp

Dừng container:

```bash
docker compose down
```

Xóa kèm volume:

```bash
docker compose down -v
```

## 💡 Một số lệnh hữu ích

- Xem logs:

```bash
docker compose logs -f app
```

- Restart service:

```bash
docker compose restart app
```

- Build lại Nginx nếu có thay đổi:

```bash
docker compose build app
```

## 📄 License

MIT License
