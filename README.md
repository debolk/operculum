Operculum
=========

REST interface for extended properties about members in De Bolk

Resources
---------

*Person*
Persons can contain the following data:
 * `uid`: The uid of the person [string]
 * `nickname`: The nickname of the person (can be empty) [string]
 * `study`: The study of the person (can be empty) [string]
 * `alive`: Wether the person is alive [boolean]
 * `inauguration`: The date of inauguration (can be empty) [date]
 * `resignation_letter`: The date the resignation letter was received (can be empty) [Date]
 * `resignation`: The date of resignation (can be empty) [date]

_methods_
`/person/{uid}`
 * GET:  
   returns a json encoded representation of the data belonging to {uid} or returns a 404 if the person is not found.

`/person/{uid}?access_token={access_token}`:
  `{access_token}` can be obtained using OAuth2 at: https://login.i.bolkhuis.nl
 * GET:  
   returns a json encoded representation of the data belonging to {uid} or returns a 404 if the person is not found.
 * PUT:
   replaces an existing object with the json encoded post data if you have a valid `{access_token}`  
 * PATCH:
   allows changing individual settings in using json encode post data if you have a valid `{access_token}`


Examples
--------

`
PATCH /person/jdoe?access_token=2d21970896a72d1ebee2d3c2a0347d57f48dbf7b
{"alive":true}
`

## Deployment
1. Install Apache, PHP5 and MySQL. Operculum depends on PHP 5.4.7 or later.
1. Execute `php ./composer.phar install --no-dev --optimize-autoloader` in the project root to install all dependencies using [Composer](http://getcomposer.org/).
1. Copy web/.htaccess.example to web/.htaccess and adapt as needed.
1. Point an apache virtual host to the ./web directory (containing .htaccess and dispatch.php).

## Testing
Blip is tested using [Codeception](http://codeception.com/). Testcases are stored in ./test.
