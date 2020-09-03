# Eneba Task

> Demo url: https://eneba.herokuapp.com/

## Table of contents

- [General info](#general-info)
- [Technologies](#technologies)
- [Quick start](#quick-start)
- [Endpoints](#endpoints)

## General info

An application that generates expressions of surprire in Lithuanian.

## Technologies

Created with:

- PHP 7.3+
- MySQL 5.7.26
- Symfony

## Quick start

```bash
# Download GitHub project or clone
git clone https://github.com/manaxi/eneba_task

# Install Dependencies
composer install

# Create database and edit .env file and add DB params

# Create expression schema
php bin/console doctrine:migrations:diff

# Run migrations
php bin/console doctrine:migrations:migrate

# Add virtual host if using Apache

# Build for production
npm run build

```

## Author

> Mantas Pečiulis
