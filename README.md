# codecorn-courses
A mythical creature that is half-unicorn and half-codec

### Docker setup for development
```
docker compose up -d
```
Or full rebuild
```
docker compose up -d --force-recreate --build
```

### Install the required dependencies
```sh
docker exec -it codecorn-website composer install
docker exec -it codecorn-website npm install
docker exec -it codecorn-website npm run dev
```

#### To run an interactive terminal run

```sh
docker exec -it codecorn-website bash
or
docker exec -it codecorn-website sh
```

The proxy server requires a `cert.pem` and `key.pem` file in the `./proxy/certificates` folder.