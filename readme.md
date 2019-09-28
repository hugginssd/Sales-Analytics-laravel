<p align="center">
    <img src="https://s-cart.org/logo.png" width="150">
</p>
<p align="center">Free open source e-commerce for business use laravel framework<br>
<b>composer create-project lanhktc/s-cart</b></p>
<p align="center">
 <a href="https://s-cart.org">Home page</a> | <a href="https://demo.s-cart.org">Demo</a> | <a href="https://demo.s-cart.org/sc_admin">Demo admin</a> | <a href="https://s-cart.org/installation.html">Installation</a> | <a href="https://s-cart.org/pro.html">S-Cart Pro</a> | <a href="https://s-cart.org/video-guide.html">Video Guide</a>
</p>
<p align="center">
<a href="https://packagist.org/packages/lanhktc/s-cart"><img src="https://poser.pugx.org/lanhktc/s-cart/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/lanhktc/s-cart"><img src="https://poser.pugx.org/lanhktc/s-cart/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lanhktc/s-cart"><img src="https://poser.pugx.org/lanhktc/s-cart/license.svg" alt="License"></a>
</p>
<p align="center"><img src="https://s-cart.org/images/screen/v3x/home-1.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v3x/home-2.jpg"></p>
Product detail
<p align="center"><img src="https://s-cart.org/images/screen/v3x/detail-1.jpg"></p>
Product bundle
<p align="center"><img src="https://s-cart.org/images/screen/v3x/detail-bundle.jpg"></p>
Product group
<p align="center"><img src="https://s-cart.org/images/screen/v3x/detail-group.jpg"></p>
Cart
<p align="center"><img src="https://s-cart.org/images/screen/v3x/cart.jpg"></p>
Admin homepage
<p align="center"><img src="https://s-cart.org/images/screen/v3x/admin-home.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v3x/admin-home-1.jpg"></p>
<p align="center"><img src="https://s-cart.org/images/screen/v3x/admin-home-2.jpg"></p>
Order list
<p align="center"><img src="https://s-cart.org/images/screen/v3x/order-list.jpg"></p>
Order detail
<p align="center"><img src="https://s-cart.org/images/screen/v3x/order-detail.jpg"></p>
Product list
<p align="center"><img src="https://s-cart.org/images/screen/v3x/product-list.jpg"></p>
Product detail
<p align="center"><img src="https://s-cart.org/images/screen/v3x/product-detail.jpg"></p>
Auth
<p align="center"><img src="https://s-cart.org/images/screen/v3x/auth.jpg"></p>
Backup
<p align="center"><img src="https://s-cart.org/images/screen/v3x/backup.jpg"></p>



## About S-cart
Free Open source E-commerce use Laravel framework for Business

## Technology
- Core <a href="https://laravel.com">Laravel Framework</a>

## List Functions of S-cart

======= SHOPPING =======

- Multi-language
- Currencies
- Customer sign up
- Purchase history
- Process cart
- Manage product: price sale, cost price, promotion price, quantity, multi images, attributes ..
- Categories product
- Brand product
- Api manager
...
======= SYSTEM MANAGEMENT =======

- Manage & permission users, groups
- Customer management
- Image management
- Order management: edit orders, update payment status, shipping status ...
- Order history
- Report:  chart, statistics, export csv, pdf...
- Generate image thumbnail, watermark
- Manage banner, logo
- Configure email SMTP
- System configuration: turn off website, hide / show products
...
======= EXTENSIONS =======

- Shipping
- Discount
- Payment
...Support for integrated extension from 3rd party

======= MODULES =======

- Blog/News
- Cms content: content categories, entries
...Support for integrated modules from 3rd party


## Requirements:

Version 3.x:

> Core laravel framework 5.8. Requirements::

```
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
```

## Installation & configuration:

<b>How to map your domain to s-cart? <a href="https://s-cart.org/installation.html">CLICK HERE</a></b>

Step1: Install last version S-cart
```
composer create-project lanhktc/s-cart
```
Step2:
- Chmod -R 777 storage
- Chmod -R 777 vendor
- Chmod -R 777 public/data

Step3:
```
- Create a new database. Example database name is s-cart
```

Step4:

=> From version 2.1.1, you can install s-cart by link: <code><b>your-domain.com/install.php</b></code>

```
Then, access your-domain.com/install.php to install S-cart.
If installing with link "install.php" unsuccessful, you can install it manually below.
```
OR manual installation:
```
- Import file sql database/s-cart.sql to database.
- Rename file .env.example to .env if file .env not exist.
- Genarate API key if APP_KEY is null. Use command "php artisan key:generate"
- Config value of file .env:
    APP_URL=http://localhost
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=s-cart
    DB_USERNAME=root
    DB_PASSWORD=
```

Step5:

NOTE: Please <b>remove</b> or <b>rename</b> file public/install.php so others cannot access it.

Step6:
- Access to url admin: your-domain/sc_admin.
- User/pass <code><b>admin</b>/<b>admin</b></code>

## Demo:

- Font-end : http://demo.s-cart.org
- Back-end: http://demo.s-cart.org/sc_admin   <code>User/pass: test/123456</code>

"# Sales-Analytics-laravel" 
