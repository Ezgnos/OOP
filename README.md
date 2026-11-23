# ООП в PHP — практические работы 1–5

Запуск (из корня архива, PHP 8.1+):

```
php pr1/index.php
php pr2/index.php
php pr2/check_missing.php
cd pr2 && composer dump-autoload && php index_composer.php && cd ..
php pr3/index.php
php pr3/experiments.php
php pr4/index.php
php pr5/index.php
php pr5/experiments.php
php pr5/final_error.php     # ожидаемо падает с Fatal error
```

Если в терминале VS Code на Windows вместо кириллицы «кракозябры»: `chcp 65001` перед запуском.
Проверка синтаксиса любого файла: `php -l путь/к/файлу.php`.
