


# Weather Forecast Microservice

## Overview
This microservice aggregates weather forecast data from multiple free APIs (such as OpenWeather and WeatherAPI) for an unlimited number of locations. A background job periodically fetches and stores weather data, and the RESTful API allows users to add new locations and retrieve the average weather forecast data for a specified period. The project is built using Laravel, MySQL, Docker, and Kafka for queue management.

## Features
- Add new locations (city names, latitude, and longitude).
- Fetch average weather forecast for a specific location over a period (e.g., last 7 days).
- Caching for faster subsequent requests.
- Data collection from multiple APIs using background jobs.
- Easy integration of new weather forecast sources.
- Logs for successful and failed data requests.
- Follows SOLID design principles for better maintainability and scalability.

## Stack
- **PHP 8+** (Laravel Framework)
- **MySQL** (Database)
- **Docker** (for environment setup and service management)
- **Kafka** (for handling job queues)
- **Redis** (for caching)

## Installation and Setup

### 1. Clone the repository:
```bash
git clone YOUR_REPOSITORY_URL
cd weather-forecast
```

### 2. Install dependencies:
```bash
composer install
```

### 3. Set up the environment variables:
- Duplicate the `.env.example` file and rename it to `.env`:
```bash
cp .env.example .env
```
- Update the database and queue configurations in the `.env` file:
```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weather_db
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=kafka
CACHE_DRIVER=redis
```

### 4. Generate the application key:
```bash
php artisan key:generate
```

### 5. Set up the database:
- Make sure you have MySQL installed and create the database:
```bash
mysql -u root -p
CREATE DATABASE weather_db;
```
- Run migrations to create the necessary tables:
```bash
php artisan migrate
```

### 6. Set up Kafka and Redis with Docker:
- Use Docker Compose to start Kafka and Redis:
```bash
docker-compose up -d zookeeper kafka redis
```

### 7. Queue Workers:
Start the queue worker to process background jobs (fetching weather data):
```bash
php artisan queue:work
```

### 8. Run the development server:
```bash
php artisan serve
```

## Usage

### Adding a new location:
To add a new location, make a POST request to `/api/locations` with the following JSON payload:
```json
{
    "name": "City Name",
    "latitude": "xx.xxxxxx",
    "longitude": "yy.yyyyyy"
}
```

### Fetching average weather data:
To fetch the average weather data for a location, make a GET request to:
```
/api/locations/{id}/average?period=7
```
This will return the average weather forecast for the past 7 days. You can modify the `period` query parameter to fetch data for a different number of days.

### Logs
- Logs are stored in the `storage/logs/laravel.log` file, and separate threads handle info and error logs.

## Testing

### Running Unit and Functional Tests:
You can run the test suite with the following command:
```bash
php artisan test
```

Make sure the database is correctly set up for testing in your `.env` file.

## Deployment
- Use Docker to easily deploy the project on any environment with the following command:
```bash
docker-compose up -d
```

## How to Contribute
- Fork the repository.
- Create a new branch for your feature or bug fix.
- Commit your changes.
- Push to your branch.
- Open a Pull Request.

## License
This project is licensed under the MIT License.
```

### Notes:
- Replace `YOUR_REPOSITORY_URL` with the actual URL of your Git repository.
- Ensure you have the necessary environment configurations set up before running the project.
