# Cities Rest API

This project is a rest API to retrieve cities information and supports CRUD operations.The dataset contains info on over **140.000** cities around the world.

## Base Endpoint

```http
GET http://domain/v1/cities

```

This is the endopint to make the requests, retrieve cities information, update or delete data. The response will be in `JSON` format.

## GET request

### City by ID

```http
GET http://domain/v1/cities?id={city_id}
```

inserting the id as a `query param` it's possible to retrieve the information of the city with that specic id.

#### Example request

```http
GET http://domain/v1/cities?id=1
```

#### Example response

```json
{
    "status": 200,
    "message": "Resource Retrieved",
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

### Cities by name

```http
GET http://domain/v1/cities?city={your_city_name}

```

Using this `URL` is possible to retrieve the information of all the cities that share the requested name.
The search is case insensitive, it's not required to titleize the city name.

#### Example request


```http
GET http://domain/v1/cities?city=rome
```

#### Example response


```json
{
    "status": 200,
    "message": "Resource Retrieved",
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

>**NOTE**: the cities are ordered by population in a decreasing order.

### City by latitude and longitude

To be very precise is possible retrieve a specific city trhough its latitude and longitute.

```http
GET http://domain/v1/cities?lat={city_latitude}&lon={city_longitude}
```

It suffice to pass `lat` and `lon` as `query params`.

#### Example request

```http
GET http://domain/v1/cities?lat=41.89193&lon=12.51133
```

#### Example response

```json
{
    "status": 200,
    "message": "Resource Retrieved",
    "data": [
        {
            "id": 150,
            "name": "Rome",
            "country": "IT",
            "population": 2318895,
            "lat": 41.89193,
            "lon": 12.51133
        }
    ]
}
```

>**NOTE**: there can't be two cities with the same latitude and longitude.
