# Wishlist API

This project was built with Laravel Framework 5.3.

## Install the Project

Clone repository and then do the composer install:

```bash
composer install
```

Configure your ```.env``` file. Do not forget to create a MySQL database and configure it in .env file.

### Migrations

All the entities and tables are represented by Models and are created in db with Laravel migrations.

Models are in:

```
app/
   > User.php
```

Migrations are in:

```
database/migrations/*
```

Run migrations and Seed (to create a dummy data)

```bash
php artisan migrate:refresh --seed
```

### Routes

All the routes os this api are in ```routes/api.php```.

Real examples:

```
POST http://localhost:8000/api/v1/authentication/
POST http://localhost:8000/api/v1/authentication/forgot_password/
```

### Test 

Run the serve command:

```bash
php artisan serve
```

## Tickets priorization

1. Create API for adding, removing and listing activities in wishlist
2. Add authentication through tokens for security
3. Add API versioning support so we can expand without regressions
4. Add possibility to support multiple wishlists per user
5. Allow customers to also wishlist Locations (Points of Interest, Cities, etc) (v2?)

### Understanding

First release: items 1, 2, 3 and 4.

I wanted to choose the ticket numbers 1, 2, 3 because they are the base of the API.
Number 1 is the goal of this project.
Number 2 represents the authentication used to do relation between users and wishlists feature, also it is responsible for the security between api endpoits.
Number 3 represents another base requirement in order to expand the api by versioning.
Number 4 is include because it is not a hard feature if you think before coding.

Second release: item 4.
