<p align="center">
  <a href="https://laravel.com" target="_blank">
    <picture>
      <source srcset="https://raw.githubusercontent.com/olat-nji/event-manager/main/resources/images/logo-white.svg" media="(prefers-color-scheme: dark)">
      <img src="https://raw.githubusercontent.com/olat-nji/event-manager/main/resources/images/logo-black.svg" width="200" alt="Event Manager Logo">
    </picture>
  </a>
</p>

# Event Manager

This repository provides a comprehensive event management system built with Laravel.

## Prerequisites

Ensure you have the following installed:

- PHP 8.1+
- Composer
- Laravel 10+
- MySQL or SQLite for testing
- Node.js & NPM

## Installation

### 1. Clone the repository
```sh
git clone <repository-url>
cd event-manager
```

### 2. Configure Nova authentication
Before running `composer install`, configure Composer to authenticate Nova using your Nova license key:

```sh
composer config http-basic.nova.laravel.com your-nova-account-email@your-domain.com your-license-key
```

For more details, visit [Nova Documentation](https://nova.laravel.com/docs/v4/installation).

### 3. Install PHP dependencies
```sh
composer install
```

### 4. Set up environment variables
```sh
cp .env.example .env
php artisan key:generate
```

### 5. Configure your database
Edit your `.env` file:

For SQLite:
```sh
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

For MySQL:
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run database migrations
```sh
php artisan migrate --seed
```

### 7. Install frontend dependencies
```sh
npm install
```

For local development:
```sh
npm run dev
```

For production:
```sh
npm run build
```

### 8. Create an admin user
```sh
php artisan nova:user
```
Follow the prompts to create a new Nova admin user.

### 9. Set up mailing configuration (Optional)
If using Mailpit for local testing, add this to your `.env` file:
```sh
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 10. Run the application
```sh
php artisan serve
```
Then visit: [http://127.0.0.1:8000](http://127.0.0.1:8000) and log in with the credentials created.
- Users are redirected to the event calendar.
- Admins are redirected to the admin dashboard at 'admin/'

## Deployment

For Nova authentication in production or CI/CD pipelines, set your Nova credentials using environment variables:

```sh
composer config http-basic.nova.laravel.com "${NOVA_USERNAME}" "${NOVA_LICENSE_KEY}"
```

Ensure `NOVA_LICENSE_KEY` is set in your production `.env` file.

For more details, visit [Nova Documentation](https://nova.laravel.com/docs/v4/installation).

## Running Tests

To execute feature tests:
```sh
php artisan test
```
Or using PHPUnit:
```sh
vendor/bin/phpunit
```

