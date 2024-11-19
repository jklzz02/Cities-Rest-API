# Cities Rest API

This is a learning project, made to learn about rest API by making one from scratch, capable of retrivieving cities information and supporting CRUD operations. The datbase used for the project contains info on over **140.000** cities around the world.

## Base Endpoint

```url
http://domain/v1/cities
```

This is the endopint to make the requests, retrieve cities information, update or delete data. The response will be in `JSON` format.

## GET request

### City by ID

```http
GET http://domain/v1/cities?id={city_id}
```

inserting the id as a `query parameter` it's possible to retrieve the information of the city with that specic id.

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

Using this `URL` is possible to retrieve the information of all the cities that share the requested name.
The search is case insensitive, it's not required to titleize the city name.

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

It's possible to retrieve a specific city trhough its latitude and longitude.

```http
GET http://domain/v1/cities?lat={city_latitude}&lon={city_longitude}
```

It suffice to pass `lat` and `lon` as `query parameters`.

#### Example request with latitude and longitude

```http
GET http://domain/v1/cities?lat=41.89193&lon=12.51133
```

#### Example response with latitude and logitude
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

It's possible to use more parameters to narrow the matching results

#### Example request with mutliple parameters

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

>**NOTE** the search is case insensitive and the results have been narrowed to one.
</details>


## Setup the Dev Environment

### Language Level and Dependencies

To run the project is required PHP **8.2** or higher and [composer](https://getcomposer.org/) in order to use its autoloader and install libraries

#### Libraries

The only used library is [vlucas/dotenv](https://github.com/vlucas/phpdotenv) a .env loader.
It is used in the [config](/src/config.php) to populate `$_ENV` super global with environment variable.

```PHP
if (file_exists(BASE_PATH . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
}
```

Needed libraries and their versions can be consulted in [composer.json](/composer.json)
to install needed libraries run:

```BASH
composer install
```

in the root directory of the project.

### Create Database and tables

In the [sql](/sql) directory, there are schemas for different type of `SQL` supported databases. It will suffice to run the chosen schema.sql script to initialize the empty tables in the database.

### Populate Database

#### Token Table

The token table is meant for testing authentication for CRUD operation, you can generate your tokens and insert them in the database.

#### Cities Table

If you've created the database successfully it will suffice to run the [seed](/sql/cities_seed.sql) script to populate the database of all the cities in the dataset.

### Config and .env Setup

In the dotenv it is possible to specify the type of database to use, make sure to use `PDO` dsn names for the database name such as: sqlite, mysql, pgsql, sqlsrv.

#### .env example for a SQLite database

```.env
database_type=sqlite
database_name=your_database.sqlite3
database_host=
database_port=
database_username=
database_password=
```

in the case of a `SQLite` database `database_name` will refer to its path, it will be joined with the root path of the project directory, so it's also possible to indicate a subdirectory.

```.env
database_name=subdir/your_database.sqlite3
```

that's how the [Database](/src/Core/Database.php) class is gonna handle the dsn

```PHP
$dsn = "sqlite:" . BASE_PATH  . $config["name"];
```

#### .env example for MySQL/PostgreSQL database

```.env
database_type=your_database_type # mysql/pgsql
database_name=your_database_name
database_host=localhost # or the IP address of your server
database_port=3306 # or the port your MySQL/PostgreSQL server uses
database_username=your_username
database_password=your_password
```

>**NOTE** username and password aren not mandatory.
