#!/bin/bash
# Exit on the first error
set -e

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
GREEN='\033[0;32m'
BLACK='\033[0m'

printf "${GREEN}Installing dependencies with apt${BLACK}\n"
debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
apt update -y && apt upgrade -y
apt install -y git php5-cli php5-common php5-mcrypt php5-curl php5-mysql libapache2-mod-php5 apache2 mysql-client-5.6 mysql-server-5.6

printf "${GREEN}Enabling PHP extensions${BLACK}\n"
php5enmod mcrypt curl mysql

printf "${GREEN}Enabling Apache modules${BLACK}\n"
a2enmod rewrite

printf "${GREEN}Linking site's public directory to Apache's webroot${BLACK}\n"
rm -R /var/www/html
ln -s /vagrant/public /var/www/html

printf "${GREEN}Enabling AllowOverride in webroot${BLACK}\n"
FIND='DocumentRoot /var/www/html'
INSERT='\t<Directory /var/www/html>\n\t\tAllowOverride All\n\t</Directory>'
CONFIG_FILE='/etc/apache2/sites-enabled/000-default.conf'
sed -i "s|$FIND|$FIND\n$INSERT|" $CONFIG_FILE

printf "${GREEN}Installing Composer${BLACK}\n"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

printf "${GREEN}Installing dependencies with Composer${BLACK}\n"
cd $SCRIPT_DIR && composer install

printf "${GREEN}Setting permissions for app \"storage\" directory${BLACK}\n"
chmod -R 777 /vagrant/app/storage

printf "${GREEN}Creating MySQL database and user${BLACK}\n"
mysql -u root -proot -e "CREATE DATABASE lanager;"
mysql -u root -proot -e "CREATE USER 'lanager'@'%' IDENTIFIED BY 'lanager';"
mysql -u root -proot -e "GRANT ALL PRIVILEGES ON lanager.* TO 'lanager'@'%';"
mysql -u root -proot -e "FLUSH PRIVILEGES;"

printf "${GREEN}Configuring MySQL to listen on all network interfaces${BLACK}\n"
FIND='127.0.0.1'
REPLACE='0.0.0.0'
CONFIG_FILE='/etc/mysql/my.cnf'
sed -i "s|$FIND|$REPLACE|" $CONFIG_FILE

printf "${GREEN}Restarting Apache${BLACK}\n"
/etc/init.d/apache2 restart

printf "${GREEN}Restarting MySQL${BLACK}\n"
/etc/init.d/mysql restart

printf "${GREEN}Updating Cron${BLACK}\n"
crontab -l | { cat; echo "*/1 * * * * php /vagrant/artisan steam:import-user-states 2>&1 | /usr/bin/logger -t lanager-import-user-states "; } | crontab -

printf "${GREEN}Initial installation completed! Please run the following to complete the installation:${BLACK}\n"
printf "${GREEN}php artisan lanager:install${BLACK}\n"