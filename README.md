# 🚀 Laravel 11 + Vue 3 + Vuetify + Sanctum (Monolithic App)

A secure full-stack monolithic application built with **Laravel 11** (backend) and **Vue 3 + Vuetify** (frontend).  
This project demonstrates:

- ✅ User authentication (Laravel Sanctum)
- ✅ Role-based access control (Manager, Web Developer, Web Designer)
- ✅ Employee content management (CRUD)
- ✅ RESTful API with policies and services
- ✅ Monolithic setup (Laravel + Vue in one project)

---

## 📦 Requirements

- PHP ^8.2
- Composer
- Node.js (v18+ recommended)
- NPM or Yarn
- MySQL / PostgreSQL (you can adapt)

---

## ⚙️ Installation

### 1. Clone the repo
```bash
git clone https://github.com/yourusername/your-repo.git
cd your-repo
```
## 2. Install dependencies
```bash
composer install
npm install
```

## 3. Environment setup
```bash
cp .env.example .env
php artisan key:generate

```
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=backend_test
DB_USERNAME=root
DB_PASSWORD=
```


## 4. Run migrations & seeders
```bash
php artisan migrate --seed

```

## 5. Build frontend (Vue + Vite)
```bash
npm run dev   # for development
npm run build # for production
```

## 6. Start Laravel server
```bash
php artisan serve
```

App will be running at: http://localhost:8000


### Default Accounts (Seeded)

| Role          | username                                           | Password |
| ------------- | ----------------------------------------------- | -------- |
| Manager       | manager                                         | 123456  |
| Web Developer | developer                                        | 123456 |
| Web Designer  | designer                                        | 123456 |



