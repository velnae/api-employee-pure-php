# Api TUtorials example
## GET
url
```text
http://localhost:8080/api/tutorials?page=0&size=3
```

body
```json
{}
```

response
```json
{
    "totalItems": 3,
    "tutorials": [
        {
            "id": 12,
            "title": "yes",
            "description": "yyyyyyyyyyyy",
            "published": false,
            "createdAt": "2023-05-24T04:26:09.000Z",
            "updatedAt": "2023-05-24T04:26:54.000Z"
        },
        {
            "id": 13,
            "title": "r",
            "description": "rrrrr",
            "published": false,
            "createdAt": "2023-05-24T05:18:06.000Z",
            "updatedAt": "2023-05-24T05:18:06.000Z"
        },
        {
            "id": 14,
            "title": "wa",
            "description": "awadawdaw",
            "published": false,
            "createdAt": "2023-05-24T05:18:54.000Z",
            "updatedAt": "2023-05-24T05:18:54.000Z"
        }
    ],
    "totalPages": 1,
    "currentPage": 0
}
```

## POST
url
```text
http://localhost:8080/api/tutorials
```

body
```json
{
    "title": "t",
    "description": "ttttttttttttt"
}
```

response
```json
{
    "id": 14,
    "title": "wa",
    "description": "awadawdaw",
    "published": false,
    "updatedAt": "2023-05-24T05:18:54.968Z",
    "createdAt": "2023-05-24T05:18:54.968Z"
}
```

## PUT
url
```text
http://localhost:8080/api/tutorials/11
```

body
```json
{
    "description": "qqqqqqqqq",
    "published": "true",
    "title": "queeee"
}
```

response
```json
{
    "message": "Tutorial was updated successfully."
}
```

## DELETE
url
```text
http://localhost:8080/api/tutorials/10
```

body
```json
{
    "id":"10"
}
```

response
```json
{
    "message": "Tutorial was deleted successfully!"
}
```