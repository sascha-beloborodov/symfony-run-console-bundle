создать файл `config/packages/health_check.yaml` и добавить:

```yaml
run_console:
  commands: ['%your-command-name%'']
```

добавить в файл `config/routes/annotations.yaml`

```yaml
run_console:
  resource: '@RunConsoleBundle/Controller'
  type: attributes
```
---
**НЕ ВКЛЮЧАТЬ НА ПРОДЕ в bundles.php**
--
TODO:
- перейти на Process 
- управлять выводом (долгий запрос, асинхронность, держать в памяти-файлах)