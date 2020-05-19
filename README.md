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

1. Copy the content of .env.example to a .env file
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

1. Create the environments file based on .env.example: ```cp .env.example .env```

   1. Set ```DB_HOST=db```
   2. ```DB_DATABASE```, ```DB_USERNAME```, ```DB_PASSWORD``` should be the same as set in ```docker-compose.yml```
2. Run ```docker-compose up -d```
3. Run ```docker-compose exec app php artisan key:generate```
4. Run ```docker-compose exec app php artisan config:cache```
5. Visit ```http://localhost```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
