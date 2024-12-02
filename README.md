# Cities Rest API

This is a learning project to explore REST APIs by creating one from scratch, supporting CRUD operations and authentication via tokens. The database used in the project contains information on over 140,000 cities around the world.

## Base Endpoint

```url
http://domain/v1/cities
```

This is the endpoint to make the requests, retrieve cities information, update or delete data. The response will be in `JSON` format.

## GET request

### City by ID

```http
GET http://domain/v1/cities?id={city_id}
```

Inserting the id as a `query parameter` allows to retrieve the information of the city with that specific id.

#### Example request with ID

```http
GET http://domain/v1/cities?id=1
```

#### Example response with ID

<details>
<summary>View JSON Data</summary>

```json
{
    "data": {
        "id": 1,
        "name": "Beijing",
        "country": "CN",
        "population": 18960744,
        "lat": 39.9075,
        "lon": 116.39723
    }
}
```

</details>

### Cities by name

```http
GET http://domain/v1/cities?city={your_city_name}

```

Use this `URL` to retrieve the information of all the cities that share the requested name.
The search is case-insensitive.

#### Example request with name

```http
GET http://domain/v1/cities?city=rome
```

#### Example response with name

<details>
<summary>View JSON Data</summary>

```json
{
    "data": [
        {
            "id": 150,
            "name": "Rome",
            "country": "IT",
            "population": 2318895,
            "lat": 41.89193,
            "lon": 12.51133
        },
        {
            "id": 13582,
            "name": "Rome",
            "country": "US",
            "population": 36323,
            "lat": 34.25704,
            "lon": -85.16467
        },
        {
            "id": 14954,
            "name": "Rome",
            "country": "US",
            "population": 32573,
            "lat": 43.21285,
            "lon": -75.45573
        },
        {
            "id": 77931,
            "name": "Rome",
            "country": "US",
            "population": 2697,
            "lat": 44.2206,
            "lon": -89.80843
        },
        {
            "id": 97045,
            "name": "Rome",
            "country": "US",
            "population": 1738,
            "lat": 40.88309,
            "lon": -89.50259
        },
        {
            "id": 123454,
            "name": "Rome",
            "country": "US",
            "population": 1019,
            "lat": 44.58506,
            "lon": -69.86922
        }
    ]
}
```

>**NOTE** cities are ordered by population in a decreasing order.
</details>


### City by latitude and longitude

To retrieve a specific city through its latitude and longitude.

```http
GET http://domain/v1/cities?lat={city_latitude}&lon={city_longitude}
```

It suffice to pass `lat` and `lon` as `query parameters`.

#### Example request with latitude and longitude

```http
GET http://domain/v1/cities?lat=41.89193&lon=12.51133
```

#### Example response with latitude and longitude
<details>
<summary>View JSON Data</summary>

```json
{
    "data":
        {
            "id": 150,
            "name": "Rome",
            "country": "IT",
            "population": 2318895,
            "lat": 41.89193,
            "lon": 12.51133
        }
}
```

>**NOTE** there can't be two cities with the same latitude or longitude.
</details>

### City by multiple parameters

To narrow the results, use multiple parameters.

#### Example request with multiple parameters

```HTTP
GET http://domain/v1/cities?name=rome&country=it
```

#### Example response with multiple parameters

<details>
<summary>View JSON Data</summary>

```json
{
    "data":
        {
            "id": 150,
            "name": "Rome",
            "country": "IT",
            "population": 2318895,
            "lat": 41.89193,
            "lon": 12.51133
        }
}

```

>**NOTE** the search is case-insensitive and the results have been narrowed to one.
</details>


## Setup the Dev Environment

### Language Level and Dependencies

To run the project is required **PHP 8.3** or higher and [composer](https://getcomposer.org/) in order to use its autoloader and install libraries, alongside the [needed extensions](https://www.php.net/manual/en/pdo.installation.php) for `PDO`, usually enabled by default.

#### Libraries

The only used library is [vlucas/dotenv](https://github.com/vlucas/phpdotenv) a .env loader.
It is used in the [config](/src/config.php) to populate `$_ENV` super global with environment variables.

```PHP
if (file_exists(BASE_PATH . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
}
```

Needed libraries and their versions can be consulted in [composer.json](/composer.json)
to install needed libraries run in the root directory of the project:

```BASH
composer install
```

### Create Database and tables

Create a database of the supported type (Mysql, PostgreSQL, SQLite). In the [sql](/sql) directory, there are schemas for different type of `SQL` supported databases. It will suffice to run the chosen schema.sql script to initialize the empty tables in the database.

### Populate Database

#### Token Table

The token table is meant for testing authentication for CRUD operation. Sample tokens can be generated using the [token generator](/bin/tokenGenerator) script.
Make sure to give execute permission to the script before trying to run it.

**Linux/MacOS**

```bash
chmod +x bin/tokengenerator 
```

Now simply run the script with this command  to generate a sample Token.

```bash
./bin/tokenGenerator
```

**Windows**

Assuming that **PHP 8.2** or higher is installed in the system.

```cmd
php /bin/tokenGenerator
```

#### Cities Table

If the database was created successfully it will suffice to run the [seed](/sql/cities_seed.sql) script to populate the database with a sample of 100 cities.

### Config and .env Setup

In the .env specify the type of database to use, make sure to use `PDO` dsn names for the database type such as: sqlite, mysql, pgsql, sqlsrv.

#### .env example for a SQLite database

```.env
DB_TYPE=sqlite
DB_NAME=your_database.sqlite3
DB_HOST=
DB_PORT=
DB_USERNAME=
DB_PASSWORD=
```

in the case of a `SQLite` database `DB_NAME` will refer to its path, it will be joined with the root path of the project directory, so it's also possible to indicate a subdirectory.

```.env
DB_NAME=subdir/your_database.sqlite3
```

that's how the [Database](/src/Core/Database.php) class will handle the **DSN**.

```PHP
$dsn = "sqlite:" . BASE_PATH  . $config["name"];
```

#### .env example for MySQL/PostgreSQL database

```.env
DB_TYPE=your_database_type # mysql/pgsql
DB_NAME=your_database_name # name of the created database
DB_HOST=localhost # or the IP address of the server
DB_PORT=3306 # or the port that the MySQL/PostgreSQL server uses
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

>**NOTE** username and password are not mandatory
