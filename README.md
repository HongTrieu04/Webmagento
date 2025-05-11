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
└── dump/
    └── myshop.sql
```

## ⚙️ Cài đặt và khởi động

### 1. Clone repo này

```bash
https://github.com/HongTrieu04/Webmagento.git
cd magento-docker
```

### 2. Copy mã nguồn Magento

Đặt mã nguồn Magento vào thư mục `myshop/`:

```bash
cp -r ./magento myshop
<path của myshop>
```

### 3. Thêm database (nếu có)

Tạo thư mục `dump/` chứa file SQL nếu đã có sẵn DB:

```bash
mkdir dump
cp ./myshop.sql dump/myshop.sql
<path của file sql>
```

## 🚀 Khởi động môi trường

### 1. Chạy Docker Compose

```bash
docker compose up -d
```

### 2. Nếu chưa mount Magento vào volume

Copy source vào volume:

```bash
docker cp ./myshop/. $(docker compose ps -q app):/var/www/html/
docker compose exec app chown -R app:app /var/www/html
```

### 3. Import database

```bash
docker cp ./dump/myshop.sql $(docker compose ps -q db):/myshop.sql
docker compose exec db bash -c "mysql -u root -pmagento magento < /myshop.sql"
```

## 🌐 Truy cập

- Magento: https://localhost:8443
- phpMyAdmin: http://localhost:8080  
  Tài khoản: `magento` / Mật khẩu: `magento`

> 📌 Có thể xuất hiện cảnh báo SSL lần đầu, chấp nhận để tiếp tục.

## 🛠 Chạy production (trên VM hoặc public IP)

Chỉnh sửa file `nginx/conf/default.conf`, dòng `server_name`:

```nginx
server_name your-public-ip-or-domain;
```

Nếu chạy local, có thể để là:

```nginx
server_name localhost;
```

hoặc

```nginx
server_name _;
```

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
