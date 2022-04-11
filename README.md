### Quick start

```bash
docker-composer up -d
```

```bash
php bin/console doctrine:migrations:migrate --no-interacte
```

```bash
php -S localhost:8000 -t public/
```

#### Create a destination

```bash
curl -X POST http://localhost:8000/api/v1/destination -H 'Content-Type: application/json' -d '{"name":"foo"}'
```

#### Create an user

```bash
curl -X POST http://localhost:8000/api/v1/user -H 'Content-Type: application/json' -d '{"name":"foo"}'
```

#### Create an export

_You will need the IDs that got above_

```bash
curl -X POST http://localhost:8000/api/v1/export -H 'Content-Type: application/json' -d '{"name":"foo","destinationId":"","createdById":""}'
```

#### List of exports

http://localhost:8000/export
