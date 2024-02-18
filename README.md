# Real estate BE

## Cài đặt môi trường
### B1 : Cài Xampp (Require version >= 8.0)
[Xampp Download](https://www.apachefriends.org/download.html).

### B2 : Cài đặt composer
[Composer Download](https://getcomposer.org/download/).

Các bước thực hiện việc cài đặt
[Setup](https://www.geeksforgeeks.org/how-to-install-php-composer-on-windows/).

## Setup project
### Clone project
Clone project vào thư mục htdocs của thư mục lưu trữ xampp

### Setup Composer cho project
```
composer install
```
hoặc

```
composer update
```

### Tạo file .env
Tạo file .env thủ công bằng cách copy file .env.example

Hoặc có thể chạy câu lệnh:

Chạy trên terminal, Ubuntu

```
cp .env.example .env
```

Chạy trên command prompt Windows
```
copy .env.example .env
```

### Set up các biến môi trường trong .env
Mở .env file và thay đổi database name (DB_DATABASE), username (DB_USERNAME) và password (DB_PASSWORD) tương ứng với tài khoản của mình (với người chưa setup gì về tài khoản thì không cần thay đổi gì).


### Key generate
```
php artisan key:generate
```

### JWT Secret generate
```
php artisan jwt:secret
```

### Migrate database
```
php artisan migrate
```

### Seed database
```
php artisan db:seed
```

### Chạy project
```
php artisan serve
```
