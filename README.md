## Docker
```
$ docker-compose up -d --build
$ docker exec -it ibd-php7 /bin/bash
```
Okay, you're in the PHP container on docker. You can try to run `composer` or `php artisan` commands.


## Laravel Project

### Database Configuration
Before you can create a new database. (It's name can be `laravelapp`)

Then, you should go and open `./www/.env` file. And fill fields according to  your database credentials: 
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravelapp
DB_USERNAME=root
DB_PASSWORD=root
```
You can import the sql dump file on this repo to your database.

### Installation
```
$ composer install
$ php artisan optimize && php artisan route:cache
```
That's okay. You can check out the project.

```
Laravel Passport Keys:

Personal access
Client ID: 1
Client secret: IzNpDno313f3tO5LvPkzA7NWy5DHP644Q3djMhti

Password grant
Client ID: 2
Client secret: XsVVB4FR0Phc8gC3MSCwB3nnAVDICHZ0gACpOHt4
```
You should use `Password grant` information in order to get `Bearer Token` from Laravel Passport. 

Now, you can get a token for API operations. You can make a request like this:

```
curl --location --request POST 'http://localhost/oauth/token' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--form 'client_id=2' \
--form 'client_secret=XsVVB4FR0Phc8gC3MSCwB3nnAVDICHZ0gACpOHt4' \
--form 'grant_type=password' \
--form 'username=test@test.com' \
--form 'password=123456'
```
You will take an `access_token` via this request. You can use it as Authorization header (Bearer)

If everything is okay, You can start to try all API request. 

### Usage
These are enpoint list for APIs:

```
+-----------+-----------------------------------------+-----------------------------------+
| Method    | URI                                     | Name                              | 
+-----------+-----------------------------------------+-----------------------------------+
| GET|HEAD  | api/categories                          | categories.index                  | 
| POST      | api/categories                          | categories.store                  | 
| DELETE    | api/categories/{category}               | categories.destroy                | 
| PUT|PATCH | api/categories/{category}               | categories.update                 | 
| GET|HEAD  | api/categories/{category}               | categories.show                   | 
| POST      | api/songs                               | songs.store                       | 
| GET|HEAD  | api/songs                               | songs.index                       | 
| DELETE    | api/songs/{song}                        | songs.destroy                     | 
| PUT|PATCH | api/songs/{song}                        | songs.update                      | 
| GET|HEAD  | api/songs/{song}                        | songs.show                        | 
| DELETE    | api/songs/{song}/favorite               | songs.favorite.delete             | 
| POST      | api/songs/{song}/favorite               | songs.favorite.add                | 
| GET|HEAD  | api/users                               | users.index                       | 
| POST      | api/users                               | users.store                       | 
| GET|HEAD  | api/users/{song}/favorites              | users.favorites                   | 
| GET|HEAD  | api/users/{user}                        | users.show                        | 
| PUT|PATCH | api/users/{user}                        | users.update                      | 
| DELETE    | api/users/{user}                        | users.destroy                     |
|           |                                         |                                   |
| GET|HEAD  | oauth/authorize                         | passport.authorizations.authorize | 
| POST      | oauth/authorize                         | passport.authorizations.approve   | 
| DELETE    | oauth/authorize                         | passport.authorizations.deny      | 
| POST      | oauth/clients                           | passport.clients.store            | 
| GET|HEAD  | oauth/clients                           | passport.clients.index            | 
| DELETE    | oauth/clients/{client_id}               | passport.clients.destroy          | 
| PUT       | oauth/clients/{client_id}               | passport.clients.update           | 
| POST      | oauth/personal-access-tokens            | passport.personal.tokens.store    | 
| GET|HEAD  | oauth/personal-access-tokens            | passport.personal.tokens.index    | 
| DELETE    | oauth/personal-access-tokens/{token_id} | passport.personal.tokens.destroy  | 
| GET|HEAD  | oauth/scopes                            | passport.scopes.index             | 
| POST      | oauth/token                             | passport.token                    | 
| POST      | oauth/token/refresh                     | passport.token.refresh            | 
| GET|HEAD  | oauth/tokens                            | passport.tokens.index             | 
| DELETE    | oauth/tokens/{token_id}                 | passport.tokens.destroy           | 
+-----------+-----------------------------------------+-----------------------------------+
```

**Note that:** 

- All parameters should be `UUID`. UUID values will be generated when a new data added to database.
- All request body must be JSON format. 


### Would you like to create a new clear project?
```
$ composer install
$ php artisan migrate
$ php artisan passport:install
$ php artisan optimize && php artisan route:cache
```

İzni Burak Demirtaş
