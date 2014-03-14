BlackBox GPS API Usage Example
==============================

Installation (Linux or Mac OS)
------------------------------

1) Install dependencies:

`cd` into the downloaded directory and run this:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

2) Create a site with it's doc root in the "web" directory.

3) Edit "web/index.php" and replace credentials with your own ones.

Using it
--------

Run it in your browser. 

Requirements
------------

* PHP 5.3+
* Your own BlackBox GPS API Client ID and Secret (see http://services.blackboxgps.com)
* A valid BlackBox GPS username & password

Thanks to
---------

* David Desberg for his great PHPoAuthLib (https://github.com/Lusitanian/PHPoAuthLib)
