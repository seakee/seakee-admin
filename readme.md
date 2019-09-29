
<p><h1>Seakee-Admin</h1></p>

<p>
<a href="https://travis-ci.org/seakee/seakee-admin"><img src="https://travis-ci.org/seakee/seakee-admin.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/seakee/admin"><img src="https://poser.pugx.org/seakee/admin/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/seakee/admin"><img src="https://poser.pugx.org/seakee/admin/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/seakee/admin"><img src="https://poser.pugx.org/seakee/admin/license.svg" alt="License"></a>
</p>

## About Seakee-Admin

The background management scaffolding developed based on Laravel6.0, Vue2.6 and Element-ui 2.10

## Install

Require this package with composer using the following command:
```bash
composer create-project seakee/admin
```
After updating composer,Edit the `.env`  to update your database configuration:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
Run the following command to run all of your outstanding migrations, execute the migrate `Artisan` command:
```bash
php artisan migrate
```
After migrated,you may use the `db:seed` Artisan command to seed your database.
```bash
php artisan db:seed
```
Install your project's frontend dependencies using the Node package manager (NPM):
```bash
npm install
```
Once the dependencies have been installed using `npm install`, you can compile your SASS files to plain CSS using [Laravel Mix](https://laravel.com/docs/6.x/mix#working-with-stylesheets). The `npm run dev` command will process the instructions in your `webpack.mix.js` file. Typically, your compiled CSS will be placed in the `public/css` directory:
```bash
npm run dev
```
## Default Account
url:http://localhost/admin

username:admin

password:admin123456

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
