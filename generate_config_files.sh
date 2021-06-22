mv config-sample.php config.php

sed -i "s/redis_host_xxx/$REDIS_HOST/g" config.php
sed -i "s/mysql_host_xxx/$MYSQL_HOST/g" config.php
sed -i "s/mysql_port_xxx/$MYSQL_PORT/g" config.php
sed -i "s/mysql_database_xxx/$MYSQL_DATABASE/g" config.php
sed -i "s/mysql_user_xxx/$MYSQL_USER/g" config.php
sed -i "s/mysql_password_xxx/$MYSQL_PASSWORD/g" config.php
sed -i "s/redis_port_xxx/$REDIS_PORT/g" config.php
