<div align="center">

# MercaTodo E-commerce

</div>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-MercaTodo">About MercaTodo</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#Login">Login</a></li>
    <li><a href="#Env-file">Env file</a></li>
    <li><a href="#Task-Scheduling">Task Scheduling</a></li>
    <li><a href="#Images">Images</a></li>
    <li><a href="#Export-Report">Export Report</a></li>
    <li><a href="#Reports">Reports</a></li>
  </ol>
</details>

## About MercaTodo

MercaTodo is a E-commerce for the Bootcamp Evertec 2023, this project is made with laravel, Vue.js, Inertia.js and Tailwindcss, we have a admin panel for the basic operations of the CRUD the users and products, we can import and export products in the format .CVS and .XLSX for easy maintenance, for the control of the store we can generate reports for the orders and user and banned users and products. the user can access to the store this have a shopping cart with a payment service placetopay and a orders history for the user. the last improvement is API REST for operations of the CRUD of the products and authentication for the users.

### Built With

* [![Vue][Vue.js]][Vue-url]  version 3.2.31
* [![Laravel][Laravel.com]][Laravel-url] version 10.0
* PHP  version 8.1.12
* Inertiajs  version 0.6.8
* Vitejs version 4.0.0
* Tailwindcss version 3.1.0


## Installation

the order to run the application, you must do the following:

1. Clone the repository with 

```sh
git clone https://github.com/DanielaRuizA/MercaTodo.git.
```

2. CD for change the directory 

```sh
cd MercaTodo
```

3. [Install PHP dependencies](https://getcomposer.org/doc/01-basic-usage.md):

```sh
composer install
```

4. [Install npm dependencies](https://docs.npmjs.com/cli/v8/commands/npm-install):

```sh
npm install
```

5. Create the .env

```sh
cp .env.example .env
```

6. Generate Key 

```sh
php artisan key:generate
```

7. Add database information, the credentials for placetopay and the email service in the .env file.

8. Run the database migrations 

```sh
php artisan migrate --seed
```

9. Run this commands for compile the assets o develop mode.

> - You can run the [development mode]
>```sh
>npm run dev
>```
>- Or build the [assets]
>```sh
>npm run build
>```

10. to see the images, run this 

```sh
php artisan storage:link
```
11. Run the pho dev server

```sh
php artisan serve
```

## Login
> For use this app in the Admi role use this credentials in the login
>
>>- **Username:** i@admin.com
>>- **Password:** 123456
>
> Or use the app like a user select a email from the database with the 
>>- **Password:** password

## .Env file

The .env file contains the configuration of the application. It is important to configure this file for a excellent app performance.
mail This app use https://mailtrap.io
PlaceToPay https://docs-gateway.placetopay.com/

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

### PlaceToPay Payment Service
>PLACETOPAY_LOGIN  
>PLACETOPAY_TRANKEY  
>PLACETOPAY_URl  

## Task Scheduling
th command scheduler offers a fresh approach to managing scheduled in this app.

```sh
php artisan queue:work
```

## Images
for storage and see the images save then in the route `storage/app/public/images` folder.

## Export Report
the export of the products is download in this route `storage/app/exports`

## Reports 
the reports are download in this route `storage\app\reports`

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/othneildrew/Best-README-Template.svg?style=for-the-badge
[contributors-url]: https://github.com/othneildrew/Best-README-Template/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/othneildrew/Best-README-Template.svg?style=for-the-badge
[forks-url]: https://github.com/othneildrew/Best-README-Template/network/members
[stars-shield]: https://img.shields.io/github/stars/othneildrew/Best-README-Template.svg?style=for-the-badge
[stars-url]: https://github.com/othneildrew/Best-README-Template/stargazers
[issues-shield]: https://img.shields.io/github/issues/othneildrew/Best-README-Template.svg?style=for-the-badge
[issues-url]: https://github.com/othneildrew/Best-README-Template/issues
[license-shield]: https://img.shields.io/github/license/othneildrew/Best-README-Template.svg?style=for-the-badge
[license-url]: https://github.com/othneildrew/Best-README-Template/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/othneildrew
[product-screenshot]: images/screenshot.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Next-url]: https://nextjs.org/
[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB
[React-url]: https://reactjs.org/
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Angular.io]: https://img.shields.io/badge/Angular-DD0031?style=for-the-badge&logo=angular&logoColor=white
[Angular-url]: https://angular.io/
[Svelte.dev]: https://img.shields.io/badge/Svelte-4A4A55?style=for-the-badge&logo=svelte&logoColor=FF3E00
[Svelte-url]: https://svelte.dev/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 
