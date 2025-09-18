# Bài Tập PHP - VuVanHaCong

## 🌐 Live Demo
**Website đang hoạt động tại**: [https://baitapphp.onrender.com/](https://baitapphp.onrender.com/)

---

## Hướng dẫn chạy website trên XAMPP

### 1. Cài đặt XAMPP
- Tải XAMPP tại: https://www.apachefriends.org/index.html
- Cài đặt và khởi động XAMPP Control Panel.

### 2. Đưa mã nguồn vào thư mục htdocs
- Copy toàn bộ thư mục `VuVanHaCong` vào `C:\xampp\htdocs\`.

### 3. Khởi động Apache
- Mở XAMPP Control Panel.
- Nhấn Start ở dòng Apache.

### 4. Truy cập website
- Mở trình duyệt và nhập địa chỉ:
  - `http://localhost/VuVanHaCong/index.php` để vào trang chính.
  - Các file HTML có thể truy cập trực tiếp, ví dụ: `http://localhost/VuVanHaCong/hoc-php.html`

### 5. Lưu ý
- Đảm bảo Apache đã chạy (biểu tượng màu xanh lá cây trong XAMPP Control Panel).
- Nếu sửa file, chỉ cần refresh trình duyệt để xem thay đổi.
- Nếu dùng chức năng PHP (bài tập, đăng nhập...), hãy truy cập qua file `.php`.

## 📋 Tổng quan dự án

### Tính năng chính:
- ✅ **11 Bài tập PHP** với các thuật toán cơ bản
- ✅ **Responsive Design** với header/navbar đồng nhất
- ✅ **Toggle Sidebar** với navigation menu
- ✅ **Session Management** cho bài tập tương tác
- ✅ **Docker Support** để deploy dễ dàng
- ✅ **Trang học tập** về HTML/CSS, JavaScript, PHP, W3Schools

### Cấu trúc trang:
- **Trang chủ** (`index.php`): Hiển thị và xử lý 11 bài tập
- **Học PHP** (`hoc-php.html`): Hướng dẫn học PHP từ cơ bản
- **Học JavaScript** (`gioi-thieu-js.html`): Giới thiệu JavaScript
- **Học CSS & HTML** (`hoc-css-html.html`): Hướng dẫn CSS và HTML
- **W3Schools** (`gioi-thieu-welscholl.html`): Giới thiệu nền tảng học lập trình

---

## 🚀 Deploy Production
**Live URL**: [https://baitapphp.onrender.com/](https://baitapphp.onrender.com/)

---

## 💻 Development Setup

### 6. Tài liệu tham khảo
- [Hướng dẫn XAMPP cơ bản](https://www.apachefriends.org/faq_windows.html)
- [Tài liệu PHP](https://www.php.net/manual/vi/)

---

## 🐳 Docker Setup

### Chạy với Docker
```bash
# Build và chạy container
docker build -t baitap-php .
docker run -p 8080:80 baitap-php

# Hoặc sử dụng docker-compose
docker-compose up -d
```

### Truy cập Docker
- **Web**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

Chi tiết xem file `DOCKER.md`

---

## 📝 Danh sách bài tập

1. **Bài 1**: Tính tổng số nguyên tố từ 1-100
2. **Bài 2a**: Tính tổng chuỗi T = 1/2 + 2/3 + ... + n/(n+1)
3. **Bài 2b**: Tính tổng chuỗi với điều kiện epsilon
4. **Bài 3**: Biểu thức toán học (placeholder)
5. **Bài 4**: Nhập số đến khi gặp 0
6. **Bài 5**: Kiểm tra số hoàn hảo
7. **Bài 6**: Tính giai thừa
8. **Bài 7**: Tìm ước số
9. **Bài 8**: Đếm số âm/dương trong mảng
10. **Bài 9**: Chuyển đổi giây thành hh:mm:ss
11. **Bài 10**: Class Person và SinhVien (OOP)

---

## 🛠️ Công nghệ sử dụng

- **Backend**: PHP 8.2
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Server**: Apache
- **Database**: MySQL (tùy chọn)
- **Container**: Docker & Docker Compose
- **Deploy**: Render.com

---

## 👤 Thông tin tác giả

- **Họ tên**: Vũ Văn Hà Công
- **Khoa**: CNTT
- **Lớp**: CNTT4-K63

---
Nếu gặp lỗi, kiểm tra lại đường dẫn, quyền truy cập hoặc port Apache (mặc định là 80).
