# Getting Started

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)


## Clone the repository
```
git@github.com:ChrisPlota/Eduity-MVP-Laravel.git
```


## Switch to the repo folder

```
cd laravel-backend
```

Copy the example env file and make the required configuration changes in the .env file

`cp .env.example .env`


```
composer install
```

Make sure you set the correct database connection information before running the migrations Environment variables

`php artisan migrate`

## Run

Start the local development server

`php artisan serve --port=8000`

You can now access the server at http://localhost:8000

## Generate JWT token
http://localhost:8000/api/jwttoken/create

## Run Unit Test

PHPUnit package is what's used for the Unit Test.

Files for the Unit Test are located in the "tests" folder.

	- Files for testing each controller are located in /tests/Unit folder.

	- Random data for Unit Testing is made in /tests/TestCase.php.

   	  This random data is not added to the database. Instead, we use the 'sqlite' driver to store the testing data in temporary memory.

To begin the Unit Test, please run the following command:

`php artisan test`