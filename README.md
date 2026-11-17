# Konnekt — Job Recruitment Platform

Web platform that connects job seekers and employers, developed for the Databases and Web Applications Laboratory (LBAW) course at FEUP (University of Porto), 2025/2026.

## Features
- **Job posts:** create, edit and delete offers; search with live suggestions; save favourites
- **Applications:** apply with a CV; employers review applications and update their status
- **Real-time messaging:** a conversation between candidate and employer for each application (Pusher)
- **Profiles:** profile photo, downloadable CV and password recovery
- **Notifications:** in-app notifications with read status
- **Administration:** manage and block users, moderate job posts and applications

## Tech stack
Laravel 12 (PHP 8.3) · PostgreSQL · Blade · Bootstrap · JavaScript · Docker · Nginx

## Documentation
- REST API specification: [`docs/a7_openapi.yaml`](docs/a7_openapi.yaml)
- Accessibility and usability evaluations, HTML/CSS validation: [`docs/`](docs)

## How to run
```bash
cp .env.example .env              # then set DB_PASSWORD
docker compose up -d              # PostgreSQL + pgAdmin
composer install
php artisan key:generate
php artisan db:seed               # create schema and sample data
php artisan serve                 # http://localhost:8000
```
Full setup guide: [`README_lbaw.md`](README_lbaw.md)

## Authors
Vasco Vieira · Leonardo Carvalho · Daniela Azevedo · Diogo Ribeiro
