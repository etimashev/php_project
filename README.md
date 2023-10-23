# Технические требования

Система с docker и git

# Подготовка (единожды)

```bash
cp postgres/.env.example postgres/.env # скопировать .env и заполнить данными postgres - (только для dev разворачивания)
cp app/.env.example app/.env # скопировать .env приложения и изменить данные для postgres
```

# Разворачивание приложения для разработки

```bash
./up.dev # собрать приложение вместе с локальным postgres

./seed_test_db # заполнить базу данных тестовыми значениями (единожды)

./down.dev # выключить приложение
```

# Разворачивание приложения для продакшена

```bash
./up.prod # собрать приложение без локального postgres

./down.prod # выключить приложение
```

# Логирование

Логи ошибок пишутся в папке logs

Для отключения логов - удалить папку logs

# Ссылки

http://localhost - Основное приложение
<br>
http://localhost:8080 - adminer, аналог phpmyadmin, но легковеснее (только для dev)
