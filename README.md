<div align="center">

# MercaTodo E-commerce

</div>

## About MercaTodo

MercaTodo is a E-commerce for the Bootcamp Evertec 2023, this project is made with laravel, Vue and inertia. we have a admin panel for see, create, delete the users and products, for the other side is the store that have a shopping cart and payment service with placetopay.

## Configuration

In order to run the application, you must do the following:

- Clone the repository with  git clone https://github.com/DanielaRuizA/MercaTodo.git.
- Run `composer install` to install the dependencies.
- Run `npm install` to install the dependencies
- Run `php artisan key:generate` to generate the application key.
- Create the .env file from the .env.example file with the command `cp .env.example .env`
- Configure .env with the database information and the credentials for placetopay and the email service.
- Run `php artisan migrate` to create the database tables.
- Run `php artisan migrate:fresh --seed` to create the seeders.
- Run `npm run build` or `npm run dev` to compile the assets.
- Run `php artisan serve` to start the serve.
- Run `php artisan storage:link` to make see the images.

## .Env file

The .env file contains the configuration of the application. It is important to configure the following variables. 

### Database Connection
>DB_CONNECTION  
>DB_HOST  
>DB_PORT  
>DB_DATABASE
>DB_USERNAME  
>DB_PASSWORD

### Mail Configuration
>MAIL_MAILER
>MAIL_HOST
>MAIL_PORT
>MAIL_USERNAME
>MAIL_PASSWORD
>MAIL_ENCRYPTION
>MAIL_FROM_ADDRESS
>MAIL_FROM_NAME

### PlaceToPay Payment Service
>PLACETOPAY_LOGIN
>PLACETOPAY_TRANKEY
>PLACETOPAY_URl
>PLACETOPAY_API

## Product Images

for storage and see the images save this in the route `storage/app/public/images` folder.

Amd run the following command:

- `php artisan storage:link`.
