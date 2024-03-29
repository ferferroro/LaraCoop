<p align="center">
  <img src="https://github.com/ferferroro/LaraCoop/blob/master/public/paper/img/LaraCoop.png?raw=true" alt="LaraCoop's Image"/>
</p>

# LaraCoop

LaraCoop is a web application made in Laravel. It is designed to handle basic Cooperative operations such as, house keeping of Funds, maintaining members along with contribution collection, maintaining borrowers and their loans.

While the initial design is to handle a Cooperative, this can also be used as a personal housekeeping app to monitor individuals that has a debts on you.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

## Demo

Preview of CoopApp is deployed on Hostinger.

Demo: http://laracoop.codecarpentry.com/ Login: admin123@gmail.com/admin123

Please dont spam the demo :)

### Prerequisites

What things you need to install the software

```
XAMPP
Laravel 7
```

### Installing

##### 1. Clone the repository:

Open a terminal or a Gitbash

*You can Fork this repo to make a copy of your own in case you want to add functionaliy

Select a directory and clone this github repo, (*If you forked this repo clone your own version, so you can commit further changes*)

```
git clone https://github.com/ferferroro/LaraCoop.git
```


##### 2.Install Requirements:

After cloning, make sure you are in the working directory

```
cd LaraCoop
```

Type in your terminal:

```
composer install
```

Create a .env file
```
cp .env.example .env
```

Generate application key
```
php artisan key:generate
```

add database config (open the .env and update the db credentials)
```
   DB_DATABASE=your_database_name 
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password  
```

Run the migrations 
```
   php artisan migrate
```

Refresh cache - generate list classes that needs to be included on the Project
```
   composer dump-autoload
```

If installing on local pc you can the command below to start the app (Note: dont run this command on production server)
```
php artisan serve
```

## Deployment

Nothing specific here, choose your own Server.

Unless you want to deploy a your own demo on Hostinger, you can always contact me ( In Hostinger, same installation steps, except we need to setup a .htaccess file).

## Built With

* [Laravel](https://laravel.com/docs/7.x) - The web framework used
* [Paper Dashboard](https://www.creative-tim.com/live/paper-dashboard-laravel) - Admin template. Please try out the [Pro Version](https://secure.2checkout.com/order/product.php?PRODS=4693413&QTY=1&AFFILIATE=147229)

## Things you can improve

1. Ajax column sorting
2. Use modal for searching records
3. Standardize coding based on your preference

## Author

* **Romel Fernando - [Buy me Coffee](https://paypal.me/ferferroro)**

## Acknowledgments

* My special someone
* My Family
* Friends
