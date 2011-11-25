Lyra CMS
========

A content management application developed with Symfony2 and Doctrine2.
Under development, it can be installed for testing/preview but not on
production sites.

Installation
============

These instructions have been tested under Linux/Unix, Windows users will
need to make all the changes needed by their OS.

1.  Create the project folder. For example:

        mkdir -p /home/sfprojects/lyra
        cd /home/sfprojects/lyra

    All subsequent shell statements must be executed with this folder as
    current directory.

2.  Clone the repository

        git clone git://github.com/mgiagnoni/LyraCMS.git .

    Do not forget the trailing `.` (dot) as you are cloning into the current
    directory.

3.  Initialize and fetch submodules

    Symfony framework and all the other dependencies are configured as
    **git submodules**, to download them from their respective repositories
    run the following commands

        git submodule init
        git submodule update

3.  Create cache and logs folders.

    As these folders are not included in the repository you need to create them.

        mkdir app/cache app/logs
        chmod 777 app/cache -R
        chmod 777 app/logs -R

4.  Build bootstrap cache

        php bin/build_bootstrap.php

5.  Customize configuration parameters

        cp app/config/parameters.yml.dist app/config/parameters.yml

    Edit `app/config/parameters.yml` and enter values for *database_host*,
    *database_name*, *database_user*, and *database_password* parameters to
    connect to a database you have previously created.

6.  Create database tables

        php app/console doctrine:schema:update --force

7.  Install assets

        php app/console assets:install web

8.  Create content root node

    The content root node (homepage) must be created with a shell command

        php app/console lyra:content:init

9.  Configure virtual host

    Create an Apache *virtual host* having the `web` directory of your
    project as **Document Root**, for example

        NameVirtualHost 127.0.0.1:8080
        Listen 127.0.0.1:8080

        <VirtualHost 127.0.0.1:8080>
          DocumentRoot /home/sfprojects/lyra/web
          <Directory /home/sfprojects/lyra/web>
            AllowOverride All
            Allow from All
          </Directory>
        </VirtualHost>

    Restart Apache to load this configuration.

10.  Access site

    http://localhost:8080/app.php/

    You can create content directly from the home page (link *Create page*
    on the right column). Or you can access the backend area at

    http://localhost:8080/app.php/admin/content/list
