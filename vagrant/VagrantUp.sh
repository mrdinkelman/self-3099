#!/bin/bash

# first of all, get latest version for OS
sudo apt-get update && sudo apt-get upgrade -y

# install apache, enable site, configures hosts
sudo apt-get install -y apache2
a2ensite $PROJECT
sudo /etc/init.d/apache2 restart
