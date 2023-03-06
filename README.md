# codecorn-courses
A mythical creature that is half-unicorn and half-codec

### # Docker setup
```
docker compose up -d
```
or full rebuild
```
docker compose up -d --force-recreate --build
```

#### Install the required dependencies
```sh
docker exec -it codecorn-website cp .env.example .env
docker exec -it codecorn-website composer install
docker exec -it codecorn-website npm install
```

#### To run an interactive terminal run

```sh
docker exec -it codecorn-website bash
```
or
```sh
docker exec -it codecorn-website sh
```

###### The proxy server requires a `cert.pem` and `key.pem` file in the `./proxy/certificates` folder.

### # Windows/Linux setup

Requires php with openssl enabled

#### Install the required dependencies
```sh
cp .env.example .env
composer install --ignore-platform-reqs
npm install
```

### Start the dev server
```sh
php artisan serve
```
or
```sh
npm run dev
```

<br>

#### The vite HMR server is running on port 8766
Open http://localhost:8765