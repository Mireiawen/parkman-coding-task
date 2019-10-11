# Parkman coding task

To run the application, you can either build the Docker container from the Dockerfile, or just run the code on PHP 7.3 web server. The code uses MariaDB 10.3 database with utf8mb4 charset, and expects database configuration in the environment.

## Database
Database is split into 2 files, `schema.sql` and `data.sql`. First you must import the schema, and then the data.

The schema is split into 4 tables, specifying countries, currencies, companies and garages.

## Code
Code is written to run on PHP 7.3, and JSON functions require the 7.3. No external libraries or frameworks are used.

The code is split to have database models separate from the views. 

Requests will return HTTP response code and JSON error message in case of errors.

The public facing `index.php` -file is under the `public` folder, while the actual application resides in the `includes` folder. In production case the server could be configured to allow access to only to the public index.php and not any other PHP script to improve security.

## Example with Docker
Example commands to run in the Docker environment, where database is expected to be set up already.

    docker 'build' --tag 'mireiawen/parkman' '.'
    docker 'run' \
    	--interactive \
    	--tty \
    	--rm \
    	--publish 'PORT_TO_PUBLISH:80' \
    	--link "DATABASE_CONTAINER:database" \
    	--env 'DATABASE_HOSTNAME=database' \
    	--env 'DATABASE_DATABASE=parkman' \
    	--env 'DATABASE_USERNAME=parkman' \
    	--env 'DATABASE_PASSWORD=secret-pass-word' \
    	'mireiawen/parkman'

## URLs
Just using HTTP GET to make it simple to test in this case. Reading JSON or such format should be trivial but requires bit more than just browser and URL to send a request. Requests are case sensitive.

### Get companies
* http://server/?request=GetAllCompanies

### Get countries
* http://server/?request=GetAllCountries

### Get garages by company
* http://server/?request=GetGaragesByCompany&company=1
* http://server/?request=GetGaragesByCompany&company=2

### Get garages by country
* http://server/?request=GetGaragesByCountry&country=1
