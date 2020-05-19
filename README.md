# Messer

A simple announcements application. Create, edit, view and delete announcements. Created with Laravel, Vue.js and MySQL.

### Improvements
- Improve unit test coverage.
- Display notifications and alerts to the user.
- Improve dashboard page.
- Better validation in the start and expire dates fields. 

## How to run

### Locally

#### Requirements:

- Node and npm
- PHP v7.4
- Compose
- MySQL

#### Steps

1. Copy the content of .env.examplo to a .env file
2. Fill out the database connection properties
3. Run ```php artisan key:generate``` to create a new app key into the .env file
4. Run ```php artisan jwt:secret``` to create a new JWT key into the .env file
5. Run ```php artisan migrate``` to create the necessary tables in the database. NOTE: make sure the database set in the .env ```DB_DATABASE``` exists.
6. Run ```npm install``` to install the node dependencies
7. Run ```npm run prod``` to bundle all dependencies
8. Run ```php artisan serve```

### Run with Docker

#### Requirements 

- Docker
- Docker-compose

#### Steps

TODO

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
