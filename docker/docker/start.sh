#!/bin/bash


service postgresql start
psql -U postgres -c "ALTER USER postgres PASSWORD 'postgres';"
nginx -g "daemon off"

sudo service php8.2-fpm start
ln -s /etc/nginx/sites-available/back.conf /etc/nginx/sites-enabled/
ln -s /etc/nginx/sites-available/front.conf /etc/nginx/sites-enabled/

curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
sudo apt install symfony-cli

sudo service nginx start

sudo composer require --dev symfony/test-pack
sudo composer require symfony/orm-pack
sudo composer require --dev symfony/maker-bundle

sudo tail -f /dev/null

