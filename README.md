Operculum
=========

REST interface for extended properties about members in De Bolk

Resources
---------

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

