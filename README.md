## Project structure
- app (main program logic)
  - Http\Controllers ( the implementations of the api handlers are placed in this path)
    - UserController ( handles the request related to the users)
    - NotificationController ( handles the requests related to sending notification)
    - ProductController ( handles the requests related to interactions with products )
  - Http\Requests ( rules for validating body content of the requests )
    - NotificationRequest ( handles the validation for the body of the sendNotification request body )
  - Services ( main logic for handling different requests )
    - Notification ( the logic for handling the notification requests )
      - NotificationInterface
      - NotificationDispatcher ( handles choosing the  right handler for the request based on the notification type )
      - EmailNotification ( implement NotificationInterface )
      - SMSNotification ( implements NotificationInterface )
    - ProductService ( handles the request for the products )
- routes ( used to setup the required api pathes and corresponding handler )

## how to run the project

to simply run the project we can use the following command in the root of the project

```bash
php artisan serve
```

however for the development [lerd](https://lerd.sh/) is used on the ubuntu to serve the project

to register the project in `lerd` we can use the following command in the root of the project
```bash
lerd link
```

after that using the following we can find out the domain it has set for the project
```bash
lerd status
```

normally the domain consists of the name of the root directory followed by a `.test`
consider the name of the root directory is `hello-api` then the domain set by the lerd will be `hello-api.test`
