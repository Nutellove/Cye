AI Eye²
=======

Experimenting BDD with various js libs :
  - webGL
  - three.js
  - paper.js
  - maybe mootools or jquery or klass


## USE

`web/index.php` contains most of the PHP glue
`view/` contains the twig templates

## INSTALL

Get composer, install, and make sure the `cache/` folder is writeable.

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

    sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx cache
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx cache
