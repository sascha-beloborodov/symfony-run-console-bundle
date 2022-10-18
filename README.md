# Бандл

### Установка

создать файл `config/packages/health_check.yaml` и поместить туда следующее содержимое (взависимости от того, что необходимо тестировать)

```yaml
health_check:
  database: []
  redis: true
  redis_dsn: '%env(string:REDIS_DSN)%'
```

добавить в файл `config/routes/annotations.yaml`

```yaml
health_check:
    resource: '@HealthCheckBundle/Controller'
    type: annotation
```

добавить в файл `config/packages/security.yaml`

```yaml
    healthz:
      pattern: ^/healthz
      anonymous: true
```

`composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://gitlab+deploy-token-37:CsKLWeecSHxmEg8j92Q8@git.leadgid.space/leadgid-platform/bundles/health-check-bundle"
        }
    ]
}
```

```json
{
    "require": {
        "leadgid-platform/health-check-bundle": "^1.0"
    }
}
```
