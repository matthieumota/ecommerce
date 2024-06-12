# Ecommerce

Un projet ecommerce avec Symfony 7. On démarre ça et on verra jusqu'où on va...

## Installation

You need to install :

- Docker
- PHP 8.2

You need to run containers :

```bash
docker compose up -d
```

## Testing

We use a database sqlite for testing.

```bash
php bin/console --env=test d:d:c
php bin/console --env=test d:s:c
```
