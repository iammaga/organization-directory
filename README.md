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
- Migrations and Seeders with consistent test data
- API Routes:
  - `GET /api/buildings` - Get a list of all buildings.
  - `GET /api/organizations/{id}` - Get details for a specific organization.
  - `GET /api/buildings/{id}/organizations` - Get organizations for a specific building.
  - `GET /api/activities/{id}/organizations` - Get organizations associated with a specific activity.
  - `GET /api/organizations/search?activity={activity_name}` - Search organizations by activity name.
  - `GET /api/organizations/search?name={organization_name}` - Search organizations by organization name.
  - `GET /api/organizations/nearby?lat={latitude}&lng={longitude}&radius={radius_in_km}` - Get organizations nearby a given location.
- JSON responses using Resource classes
- Swagger documentation via L5-Swagger

## Setup and Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/iammaga/organization-directory.git
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

4.  **Update `.env` file for local MySQL:**

    -   Ensure your local MySQL server is running.
    -   Create a database named `laravel` (or your preferred name) in your MySQL server.
    -   Ensure you have a MySQL user with appropriate permissions (e.g., `root` with password `root` if configured that way).
    -   Set the following in your `.env` file:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=8889 # Or your MySQL port
        DB_DATABASE=laravel
        DB_USERNAME=root # Or your MySQL username
        DB_PASSWORD=root # Or your MySQL password
        ```

5.  **Run migrations and seed the database:**

    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Generate Swagger documentation:**

    ```bash
    php artisan l5-swagger:generate
    ```

7.  **Start the development server:**

    ```bash
    php artisan serve
    ```

## API Usage

The API is accessible at `http://127.0.0.1:8000/api` (assuming default `php artisan serve` port).

**Example Request (using curl):**

```bash
curl http://127.0.0.1:8000/api/organizations/1
```

## Swagger Documentation

Access the API documentation at `http://127.0.0.1:8000/api/documentation`.

## Example API Responses

Here are examples of what you might get from the API endpoints:

**GET /api/organizations/1**
```json
{
  "data": {
    "id": 1,
    "name": "Krajcik, Emard and Robel",
    "phones": [
      "+15205835371",
      "1-508-793-4976"
    ],
    "activities": [
      "debitis",
      "non",
      "dolores",
      "ipsa"
    ]
  }
}
```

**GET /api/buildings**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Gerhold and Sons",
      "address": "42913 Kathlyn Tunnel\nNew Haydenville, AL 83596-4529",
      "lat": "55.7512450",
      "lng": "37.6184240"
    },
    {
      "id": 2,
      "name": "Willms-Schroeder",
      "address": "525 Steuber Manors Suite 698\nCreminfurt, LA 49306",
      "lat": "-82.7104850",
      "lng": "6.2208990"
    }
    // ... more buildings
  ]
}
```

**GET /api/buildings/1/organizations**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Krajcik, Emard and Robel"
    },
    {
      "id": 2,
      "name": "Windler, Reilly and Nienow"
    }
    // ... more organizations in building 1
  ]
}
```

**GET /api/activities/1/organizations**
```json
{
  "data": [
    {
      "id": 4,
      "name": "Gerhold, Stehr and Harris"
    },
    {
      "id": 8,
      "name": "Hintz-Abernathy"
    }
    // ... more organizations for activity 1
  ]
}
```

**GET /api/organizations/search?name=LLC**
```json
{
  "data": [
    {
      "id": 3,
      "name": "Borer LLC"
    },
    {
      "id": 12,
      "name": "Hoeger LLC"
    }
    // ... more organizations with 'LLC' in name
  ]
}
```

**GET /api/organizations/nearby?lat=55.751244&lng=37.618423&radius=1**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Krajcik, Emard and Robel",
      "phones": [
        "+15205835371",
        "1-508-793-4976"
      ],
      "activities": [
        "debitis",
        "non",
        "dolores",
        "ipsa"
      ]
    },
    {
      "id": 2,
      "name": "Windler, Reilly and Nienow",
      "phones": [
        "1-508-793-4976",
        "+15205835371"
      ],
      "activities": [
        "debitis",
        "non",
        "dolores",
        "ipsa"
      ]
    }
    // ... more nearby organizations
  ]
}
```
