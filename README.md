# Organization Directory REST API

This is a Laravel 12 REST API project for managing organizations, buildings, and activities.

## Features

- Models: Organization, Building, Activity, OrganizationPhone
- Relationships:
  - Organization belongsTo Building
  - Organization hasMany OrganizationPhone
  - Organization belongsToMany Activity
  - Activity hasMany children (self-referencing, max 3 levels)
  - Building hasMany Organization
- Migrations and Seeders with test data
- API Routes:
  - `GET /api/buildings`
  - `GET /api/organizations/{id}`
  - `GET /api/buildings/{id}/organizations`
  - `GET /api/activities/{id}/organizations`
  - `GET /api/organizations/search?activity=еда`
  - `GET /api/organizations/search?name=копыта`
  - `GET /api/organizations/nearby?lat=55.7558&lng=37.6173&radius=5`
- Middleware: X-API-KEY authentication
- JSON responses using Resource classes
- Swagger documentation via L5-Swagger
- Docker environment (nginx, php-fpm 8.3, mysql)

## Setup and Installation

1.  **Clone the repository:**

    ```bash
    git clone <repository_url>
    cd OrganizationDirectory
    ```

2.  **Install Composer dependencies:**

    ```bash
    composer install
    ```

3.  **Copy `.env.example` to `.env` and generate application key:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Update `.env` file:**

    -   Set `DB_CONNECTION=mysql`
    -   Set `DB_HOST=mysql`
    -   Set `DB_PORT=3306`
    -   Set `DB_DATABASE=laravel` (or your preferred database name)
    -   Set `DB_USERNAME=sail` (or your preferred username)
    -   Set `DB_PASSWORD=password` (or your preferred password)
    -   Add `API_KEY=your_secret_api_key` (replace `your_secret_api_key` with a strong, random key)

5.  **Build and start Docker containers:**

    ```bash
    docker compose up -d --build
    ```

6.  **Run migrations and seed the database:**

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

7.  **Generate Swagger documentation:**

    ```bash
    ./vendor/bin/sail artisan l5-swagger:generate
    ```

## API Usage

The API is accessible at `http://localhost/api`.

**Authentication:**
All API routes require an `X-API-KEY` header with the secret key configured in your `.env` file.

**Example Request (using curl):**

```bash
curl -H "X-API-KEY: your_secret_api_key" http://localhost/api/buildings
```

## Swagger Documentation

Access the API documentation at `http://localhost/api/documentation`.

## Stopping Docker Containers

```bash
docker compose down
```