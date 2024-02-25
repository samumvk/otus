# Инсталяция
1. Установить Docker
2. Перейти в папку docker
3. Запустить 'docker up -d' 
4. В контейнере php-frm запустить команду 'composer update'

# Миграции

1. <b>Проверить валидность описания:</b> php bin/console doctrine:schema:validate
2. <b>Созадние миграции :</b> php bin/console doctrine:mi:diff
3. <b>Выполнение миграции :</b> php bin/console doctrine:mi:mi


# Кеш

* <b>Очистить кеш:</b> php bin/console cache:clear
 

