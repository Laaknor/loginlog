#!/bin/bash

#mv /mnt/srv1_data/prog/loginlog/log.txt /opt/log.txt
php /var/www/loginlog/post.php
rm /opt/log.txt
