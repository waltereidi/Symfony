#!/bin/bash


service postgresql start
psql -U postgres -c "ALTER USER postgres PASSWORD 'postgres';"

psql -U postgres -c "CREATE DATABASE biblioteca2"

nginx -g "daemon off"

sudo service php8.2-fpm start
ln -s /etc/nginx/sites-available/back.conf /etc/nginx/sites-enabled/
ln -s /etc/nginx/sites-available/front.conf /etc/nginx/sites-enabled/

curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
sudo apt install symfony-cli
echo "127.0.0.1 host.docker.internal" >> /etc/hosts
sudo service nginx start

sudo tail -f /dev/null


