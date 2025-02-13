#! /usr/bin/bash

sudo apt update
sudo apt install redis-server -y
sudo systemctl enable redis
sudo systemctl start redis
sudo apt install php-redis -y
sudo systemctl enable redis
sudo systemctl start redis
sudo apt install php-redis -y


