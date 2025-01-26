# Platform to help small to medium businesses manage their operations.

> Minimalist platform to help small businesses manage their sales, customers, inventory, accounting and any necessary operations.

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A modern, scalable e-commerce platform built with Laravel and Vue.js, designed to support multiple stores with shared infrastructure and independent
customization.

### Core Features

- 📦 Product Management
- 🛒 Order Processing
- 👥 Customer Management
- Inventory management
- 📊 Basic Analytics Dashboard
- 🔍 Essential Accounting

### Technical stack

- ⚡ Laravel + Inertia.js + Vue.js + TailwindCSS Stack

## 🔧 Requirements

- PHP 8.1 or higher
- Node.js 16+ and NPM
- MySQL 8.0+
- Composer
- Git

## 🚀 Installation

1. Clone the repository

```bash
git clone https://github.com/webitops/busywand.git
```

```bash
cd busywand
```

2. Install PHP dependencies

```bash
composer install
```

3. Install NPM dependencies

```bash
npm install
```

4. Configure environment

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

5. Set up database

```bash
php artisan migrate --seed
```

6. Build assets

```bash
npm run build
```

7. Start the server (if you don't have one already)

```bash
php artisan serve
```

## 💻 Development Setup

### Development Server

```bash
# Run Laravel development server  (if you don't have one already)
php artisan serve
```

```bash
# Watch for asset changes
npm run dev
```

### Testing

```bash
# Run PHP tests
php artisan test
```

## 🗺️ Roadmap

- [ ] Multi-language Support

## 📄 License

This project is licensed under the MIT License.

## 🤝 Contributing

Contributions are welcome! Please read our [Contributing Guide](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull
requests.

## 📧 Support

For support, please open an issue in the GitHub issue tracker or contact the maintainers.

---

Maintained with ❤️ by Webitops.

