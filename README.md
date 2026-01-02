# Laravel 12 Modules Boilerplate

A professional, modular starter kit for **Laravel 12**. This boilerplate allows you to break your application into independent, reusable modules (e.g., Blog, User, Billing), moving away from the traditional monolithic folder structure.

## Features

* **Modular Architecture:** Support for independent modules with their own Controllers, Models, Migrations, and Views.
* **Laravel 12 Ready:** Built on the latest version of Laravel with PHP 8.2+ support.
* **Auto-Registration:** Modules are automatically detected and loaded.
* **Clean Separation:** Keeps the `app/` directory clean and focuses development within the `Modules/` directory.
* **Ready-to-use Command:** Custom Artisan commands to generate new modules instantly.

---

## Directory Structure

Each module follows the standard Laravel convention, making it intuitive for any Laravel developer:

```text
app/
Modules/
└── Blog/
    ├── Http/
    │   ├── Controllers/
    │   └── Requests/
    ├── Models/
    ├── Providers/
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    ├── resources/
    │   ├── js/
    │   └── pages/
    │       └── Blog/
    │           └── Index.vue
    └── routes/
        ├── web.php
        └── api.php

```

---

## Installation

1. **Clone the repository:**
```bash
git clone https://github.com/rnyll-pntnr/rag-module-vue.git
cd rag-module-vue

```


2. **Install dependencies:**
```bash
composer install
npm install

```


3. **Environment Setup:**
```bash
cp .env.example .env
php artisan key:generate

```


4. **Run Migrations:**
```bash
php artisan migrate

```

5. **Run Development:**
```bash
composer run dev

```



---

## Usage

### Creating a New Module

To generate a new module, use the built-in artisan command:

```bash
php artisan make:module {ModuleName}

```

### Module Routing

Routes are automatically loaded for each module. You can find them in:

* **Web:** `Modules/YourModule/routes/web.php`
* **API:** `Modules/YourModule/routes/api.php`

### Using Views

Access views using the module namespace:

```php
return Inertia::render('Blog/Index');

```

---

## ✅ Requirements

* PHP ^8.2
* Laravel ^12.0
* Composer ^2.0
* [Laravel Modules](https://github.com/nWidart/laravel-modules)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.