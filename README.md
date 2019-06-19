# Yupii
![Yupii Icon](http://yupii.org/img/Yupii_logo_40.png)

Yupii is a package for CodeIgniter that allows you to easily create
Business Applications in the blink of an eye!!

http://www.yupii.org

## Installation

Download the zip file from [here](https://github.com/cgarciagl/Yupii/zipball/master) and unzip the files on your Codeigniter project directory.

Then open the **./application/config/routes.php** file and add this line at the end of the file:

```php
include_once(APPPATH.'third_party/yupii/config/autoload.php');
```
And in the file **./application/config/autoload.php** change the autoload line for packages:

```php
$autoload['packages'] = array(APPPATH.'third_party/yupii');
```

That's it!, you can start to create your new great application!

