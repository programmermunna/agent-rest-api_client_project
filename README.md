# Agent Rest Api

### Setup step by step
Clone this Repository
```sh
git clone https://github.com/cikatech-organization/agent-rest-api.git
```

Create the .env file
```sh
cd agent-rest-api
cp .env.example .env
```

PHP version to be +8.0

Install project dependencies
```sh
composer install
```


Generate the Laravel project key
```sh
php artisan key:generate
```

Run the project on local server
```sh
php artisan serve
```


Access the project
[http://localhost:8000](http://localhost:8000)
