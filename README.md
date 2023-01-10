## About

This project was created with Laravel 9.47.0, the intention is to show how to create an api and a web application that communicates with the api in a simple way, for customer management. It was MVC pattern and Repository pattern.

## Install

Check if the .env file exists in the project, if not, copy the .env.example file, now paste it in the root folder of the project,
then change the name from .env.example to .env

On project folder execute this commands

1 - Make docker run
```
docker-compose up -d
```

2 - Enter the container
```
docker exec it - client-management bash
```

3 - Install the dependencies
```
composer install
npm install
```

4 - Generate the key
```
php artisan key:generate
```

5 - Run migrations
```
php artisan migrate
```

6 - Run app
```
npm run dev
```