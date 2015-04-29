Pipiou
======

A small symfony2 project to discover "The greatest places to pee in the world".

Requirements
------------
- PHP 5
- MySql
- Composer

Installation
------------

```
# load dependencies
> composer install

# check your db config in 
> app/config/parameters.yml

# run you mysql server (xampp or whatever)

# if database not created
> php app/console doctrine:database:create

# update database schema
> php app/console doctrine:schema:update --dump-sql
> php app/console doctrine:schema:update --force

# load test data in db (use --append if you want to keep the existing data)
> php app/console doctrine:fixtures:load 

#profit
> php app/console server:run
```
