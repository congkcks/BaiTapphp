# 🐳 Docker Setup cho Bài Tập PHP

## Hướng dẫn chạy ứng dụng với Docker

### Yêu cầu
- Docker Desktop đã được cài đặt
- Docker Compose

### Cách 1: Chỉ chạy web server (đơn giản)
```bash
# Build và chạy container
docker build -t baitap-php .
docker run -p 8080:80 -v ${PWD}:/var/www/html baitap-php
```

### Cách 2: Chạy với docker-compose (đầy đủ với database)
```bash
# Chạy tất cả services
docker-compose up -d

# Hoặc build lại và chạy
docker-compose up --build -d
```

### Truy cập ứng dụng
- **Trang web chính**: http://localhost:8080
- **phpMyAdmin** (nếu dùng compose): http://localhost:8081

### Thông tin Database (nếu dùng docker-compose)
- **Host**: db
- **Database**: baitap_db
- **Username**: baitap_user
- **Password**: baitap_pass
- **Root Password**: rootpassword

### Các lệnh hữu ích

```bash
# Xem logs
docker-compose logs web

# Restart services
docker-compose restart

# Dừng tất cả
docker-compose down

# Dừng và xóa volumes
docker-compose down -v

# Vào container để debug
docker exec -it baitap-php-web bash
```

### Cấu trúc Docker
- **Dockerfile**: Cấu hình PHP 8.2 + Apache
- **docker-compose.yml**: Orchestration với MySQL + phpMyAdmin
- **.dockerignore**: Loại trừ files không cần thiết

### Lưu ý
- Port 8080 cho web server
- Port 8081 cho phpMyAdmin
- Port 3306 cho MySQL
- Code được mount từ host vào container để development thuận tiện