# Uderon LAMP server

Web-site for fun and learning

## Getting Started

You need to:
- [Setup server with Ubuntu 18-04](https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-18-04)
- [Install LAMP stack on it](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04)
- Configurate new apache vhost with Directory `/var/www/uderon.com/html`
- You will need `python3` also


### Installing

Now, clone the repo, wherever you want:

    git clone https://github.com/Jeka434/uderon.git uderon

Make a symlink into your vhost directory (**_without_ /html**):

    ln -s uderon/uderon.com /var/www/uderon.com

You can already create some **index.html** in **/uderon.com/html/**.

## Twig and config.yml

I use [**Twig**](https://twig.symfony.com/doc/2.x/templates.html) to build *.html* and *.php* with YAML file `config.yml` folowing these rules:

e.g. we want directory **html/** contain:
- **html/**
  - **errors/**
    - **index.php**
    - **error403.html**
    - **error404.html**
  - **index.php**
  - **list.html**
  - **login.php**

Write `config.yml` file like this:

    UDERON_CONSTANTS:
        - FILES_TO_BUILD:
            - html:
                - error:
                    - error__index.php: index.php
                    - error403.html
                    - error404.html
                - index.php
                - list.html
                - login.php
        - TEMPLATE_PARAMS:
            - css_version: 1.41 #Just param fo Twig
        - BUILD_DIR: uderon.com

Create **Twig** templates in **temlates/** dir and name them as left names from YAML-file with **_.tmpl_** at the end. And run:

    make



## Running the tests
To create symlinks of **html/\*** in **test/** dir run:

    make test

To delete them:

    make untest

# LOL
