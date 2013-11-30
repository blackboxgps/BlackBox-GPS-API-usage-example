BlackBox GPS API Usage Example
==============================

Installation
------------

1) Install dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

2) Create an Apache site with doc root in the /web directory

3) Edit /web/index.php and replace credentials with your own ones

Using it
--------

Run it in your browser. 

Requirements
------------

* PHP 5.3+
* Your own BlackBox GPS API Client (see http://services.blackboxgps.com)
* A valid BlackBox GPS username & password

Thanks to
---------

* David Desberg for his great PHPoAuthLib (https://github.com/Lusitanian/PHPoAuthLib)
