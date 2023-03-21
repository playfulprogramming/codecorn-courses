# codecorn-courses

A mythical creature that is half-unicorn and half-codec.

## # Docker setup

```bash
docker compose up -d
```

or full rebuild.

```bash
docker compose up -d --force-recreate --build
```

### Install the required dependencies in the docker container

```bash
docker exec -it codecorn-website cp .env.example .env
docker exec -it codecorn-website composer install
docker exec -it codecorn-website npm install
```

#### To run an interactive terminal run

```bash
docker exec -it codecorn-website bash
```

##### The proxy server requires a `cert.pem` and `key.pem` file in the `./proxy/certificates` folder but is disabled by default and not required.

## # Windows/Linux setup

Requires php with openssl enabled.

### Install the required dependencies on your machine

```bash
cp .env.example .env
composer install --ignore-platform-reqs
npm install
```

## Setup a test mail server for the 2fa and email verification steps

Follow the instructions in the [laravel docs](https://laravel.com/docs/10.x/mail#mail-and-local-development) for a test mail server. </br>
Or fill in the `MAIL_*` variables in the `.env` file for a real mail server.

### Start the dev server

```bash
npm run dev
```

or

```bash
php artisan serve
```

#### The vite HMR server is running on port 8766

Open <http://localhost:8765>
