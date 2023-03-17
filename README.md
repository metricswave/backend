
# Run and build project from scratch

We are usign [Laravel Sail](https://laravel.com/docs/10.x/sail) to run the project inside Docker.

To run this project clone this repo and run the next command inside the root folder:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Then you can just run `./vendor/bin/sail up -d`. You can find more information about Laravel Sail in the [official documentation](https://laravel.com/docs/10.x/sail).
