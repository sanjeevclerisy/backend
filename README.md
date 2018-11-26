##Demo Application
================

This is a demo application created as the backend API that includes CRUD operations.

##Requirements
------------
  * Symfony 3.4;
  * PHP 5.5.9 or higher;
  * PDO-PGSQL extension enabled;
    
##Installation
------------  
	1. Create project using composer
		```bash
		composer create-project symfony/backend
		```
	2. Create database using following command(Before running this command, verify database credentials in parameters.yml):-
		```bash
		$ php bin/console doctrine:database:create
		```
	3. Create table using following command:-
		```bash
		$ php bin/console doctrine:schema:update --force
		```
		
##Usage
-----

Run app on localhost or ip by using following commands:-
	1. 'on IP' 
		```bash
		$ php bin/console server:run {YOUR-IP-ADDRESS}:8000 
		```
	2. 'on local'
		```bash
		$ php bin/console server:run
		```
To verfiy your API's are working or not, access the application in your browser at http://{YOUR-IP-ADDRESS}:8000 or http://localhost:8000:
