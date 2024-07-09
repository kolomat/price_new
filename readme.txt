1. Изменить пути и доступы к бд в файле config.php и admin/config.php
2. Залить бд из файла price_new.sql
3. Поставить на cron задачу wget -o /dev/null -O/dev/null {прописать домен с http или https}/zoxml2.php?YML3e146f26ab495556264f74bb64350e77
Пример wget -o /dev/null -O/dev/null http://price-new.loc/zoxml2.php?YML3e146f26ab495556264f74bb64350e77
4. Ссылка на прайс {ваш домен}/index.php?route=extension/feed/yandex_yml
Пример http://price-new.loc/index.php?route=extension/feed/yandex_yml