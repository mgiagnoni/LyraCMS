Lyra CMS
========

A content management application developed with Symfony2 and Doctrine2.
Under development, it can be installed for testing/preview but not on
production sites.

Installation
============

These instructions have been tested under Linux/Unix, Windows users will
need to make all the changes needed by their OS.

1.  Install application source code with Composer:

        curl -s http://getcomposer.org/installer | php
        php composer.phar create-project lyra/cms-application path/to/install

`path/to/install` is the path to the folder where Lyra CMS application will be
installed; it must not exist because it will be created by Composer.

2.  Customize configuration parameters

    Edit `app/config/parameters.yml` and enter values for *database_host*,
    *database_name*, *database_user*, and *database_password* parameters.

3.  Create database

    If database doesn't already exist, create it with the follwing command:

        php app/console doctrine:database:create

4.  Create database tables

        php app/console doctrine:schema:update --force

5.  Create content root node

    The content root node (homepage) must be created with a shell command

        php app/console lyra:content:init

8.  Configure virtual host

    The `web` directory of your project must be configured as web server
    **Document Root**. Here is an example of a configuration of an Apache
    *virtual host*

        NameVirtualHost 127.0.0.1:8080
        Listen 127.0.0.1:8080

        <VirtualHost 127.0.0.1:8080>
          DocumentRoot path/to/install/web
          <Directory path/to/install/web>
            AllowOverride All
            Allow from All
          </Directory>
        </VirtualHost>

    `path/to/install` is the path used at step 1. Restart Apache to load this configuration.

9.  Access site

    http://localhost:8080/app.php/

    You can create content directly from the home page (link *Create page*
    on the right column). Or you can access the backend area at

    http://localhost:8080/app.php/admin/content/list
