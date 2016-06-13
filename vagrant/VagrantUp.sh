#!/bin/bash

echo "System updating..."
sudo apt-get update && sudo apt-get upgrade -y

echo "Installing: apache2..."

sudo apt-get install -y apache2

echo "Creating virtual host $PROJECT..."
echo "
<VirtualHost *:80>
  DocumentRoot /var/www/$PROJECT/
  ServerName $PROJECT
  ServerAlias www.$PROJECT
  <Directory /var/www/$PROJECT/>
    Options +Indexes +Includes +FollowSymlinks
    Order allow,deny
    Allow from all
    Require all granted
    
  </Directory>
  
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined  
</VirtualHost>" > /etc/apache2/sites-available/$PROJECT.conf

echo "Updateing /etc/hosts..."
echo "$IP $PROJECT" >> /etc/hosts

a2ensite $PROJECT
sudo /etc/init.d/apache2 restart

echo "Installing git and gitflow..."
sudo apt-get install git git-flow -y

echo "Installing htop, debconf-utils..."
sudo apt-get install htop debconf-utils -y

echo "Installing MySQL server, setting password for 'root'..."
export DEBIAN_FRONTEND=noninteractive
sudo -E apt-get -q -y install mysql-server 
mysqladmin -u root password $MYSQL_ROOT_PASSWORD

echo "Building dependencies for pbpbrew:php5..."
apt-get build-dep php5 -y
apt-get install -y php5 php5-dev php-pear autoconf automake curl libcurl3-openssl-dev build-essential libxslt1-dev 
apt-get install -y re2c libxml2 libxml2-dev php5-cli bison libbz2-dev libreadline-dev
apt-get install -y libfreetype6 libfreetype6-dev libpng12-0 libpng12-dev libjpeg-dev libjpeg8-dev libjpeg8  libgd-dev libgd3 libxpm4 libltdl7 libltdl-dev
apt-get install -y libssl-dev openssl
apt-get install -y gettext libgettextpo-dev libgettextpo0
apt-get install -y libicu-dev
apt-get install -y libmhash-dev libmhash2
apt-get install -y libmcrypt-dev libmcrypt4

echo "Installing phpbrew..."
cd /tmp && curl -L -O https://github.com/phpbrew/phpbrew/raw/master/phpbrew
chmod +x phpbrew && sudo mv phpbrew /usr/local/bin/phpbrew
phpbrew init
echo "source /home/$SSH_USER/.phpbrew/bashrc" >> /home/$SSH_USER/.bashrc
echo "source /root/.phpbrew/bashrc" >> ~/.bashrc
echo "Listing all known php versions..."
phpbrew known
echo "Installing php - $PHP_VERSION..."
phpbrew --debug install $PHP_VERSION +dbs +mb +default +bcmath +bz2 +calendar +ctype +dom +fileinfo +exif +ftp +gettext +hash +iconv +imap +intl +kerberos +openssl +tokenizer +xmlrpc +zip +apxs2=/usr/bin/apxs2 +fpm -- --enable-maintainer-zts
sudo service apache2 restart
phpbrew list
echo "Switch to already installed php version..."
phpbrew switch php-$PHP_VERSION
sudo service apache2 restart        
phpbrew list
echo "Installing additional extensions..."
phpbrew --debug ext install pthreads 2.0.10
phpbrew --debug ext install xdebug
sudo service apache2 restart 
echo "Installing additional apps..."       
phpbrew app get composer
phpbrew app get phpunit
sudo service apache2 restart 
echo "Tuning already installed php..."

echo "Update project dependencies via composer..."
cd /var/www/$PROJECT && composer update

echo "Restoring db from source..."
mysql -uroot -p$MYSQL_ROOT_PASSWORD -f < /var/www/$PROJECT/vagrant/task/make_database.sql

echo "$PROJECT is tuned in! Happy coding and have a nice day ;)"
