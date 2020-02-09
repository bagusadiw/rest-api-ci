# ci-rest-structure
CodeIgniter HMVC rest api structure with JWT integration

# Dependencies
PHP 5.x above <br />
Composer [https://getcomposer.org/]

# Installation instructions
```Run composer install ``` to install all the vendor dependencies<br />
Config database file to test the project

# Endpoint
Assume your folder project is placed inside ```xampp/htdocs```<br /> 
and accessed via ```postman```

Get all product
### `Method GET`
### `http://localhost/ci-rest/v1/product`

Get specific product
### `Method GET`
### `http://localhost/ci-rest/v1/product/:id`

Post new product
### `Method POST, Body type JSON`
### `http://localhost/ci-rest/v1/product`

Update product
### `Method PUT, Body type JSON`
### `http://localhost/ci-rest/v1/product/:id`

Delete product
### `Method DELETE`
### `http://localhost/ci-rest/v1/product/:id`