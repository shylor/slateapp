slateapp
========

Slate is a Basic Web Framework built above CodeIgniter.

## Install Guide

1. Download and unpackage code.
2. Setup URL Rewriting depending on the server you have. (see below)
4. Import slate.sql into your database.
5. configure applications/config/database.php to match your mysql setup.
6. Start coding.

## Contact
If you get stuck or find a bug feel free to contact me chris.shylor@gmail.com!

## URL Rewriting


### Apache
If you are using Apache for your web server, you will need to create a '.htaccess' file in your website root directory.

Example '.htaccess' file:

```
RewriteEngine on
RewriteCond $1 !^(index\.php|assets|robots\.txt)
RewriteRule ^(.*)$ /index.php/$1 [L]
```

### nginx
If you are using nginx, simply ensure that in your server block '=404' is not at the end of the 'try_files' line but '/index.php' is.

Example of a wrong server block snippet:

```
location / {
	try_files $uri $uri/ =404;
}
```

Example of a correct server block snippet:

```
location / {
	try_files $uri $uri/ /index.php;
}
```

## Email Settings
If you do not have a built in mail server to send emails, use the settings below with a smtp service like sendgrid, mandrill, or mailgun.

### No Email Server

```
<?php
$config['protocol'] = 'smtp';
$config['smtp_host'] = '';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';

$config['mailtype'] = 'html';
?>
```