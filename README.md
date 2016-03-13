# Scaleway Debian 8 install cheatsheet

## Update
```bash
apt update
apt upgrade
```

## byobu
```bash
apt install byobu
byobu

# F2: New session
# F3: Switch between sessions
```

## Firewall
- https://www.digitalocean.com/community/tutorials/how-to-setup-a-firewall-with-ufw-on-an-ubuntu-and-debian-cloud-server

```bash
apt install ufw

# https://community.scaleway.com/t/how-to-configures-iptables-with-input-rules-with-dynamic-nbd/303/21
nano /etc/default/ufw
IPV6=no
DEFAULT_INPUT_POLICY="ACCEPT"

nano /etc/ufw/after.rules
# Add before the final COMMIT line:
-A ufw-reject-input -j DROP

ufw logging off
ufw allow ssh
ufw allow http
ufw show added
ufw enable
ufw status
```

## fail2ban
```bash
apt install fail2ban
nano /etc/fail2ban/jail.conf

destemail = votremail@domain.com
action = %(action_mwl)s

# action_ => simple ban
# action_mw => ban et envoi de mail
# action_mwl => ban, envoi de mail accompagné des logs

service fail2ban restart
```

## New user
```bash
adduser spout
usermod -g www-data spout
```

## Mail
```bash
dpkg-reconfigure exim4-config
```

1. internet site; mail is sent and received directly using SMTP
2. System mail name: ENTER
3. IP-addresses: ENTER
4. Other destinations: ENTER
5. Domains to relay mail for: ENTER
6.  Machines to relay mail for: ENTER
7. Keep number of DNS-queries minimal: NO
8. Delivery method: mbox format
9. Split configuration into small files: NO
10. Root and postmaster mail recipient: ENTER

## Dotdeb
https://www.dotdeb.org/instructions/

```bash
nano /etc/apt/sources.list

# Dotdeb
deb http://packages.dotdeb.org jessie all
deb-src http://packages.dotdeb.org jessie all

wget https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg

apt update
```

## PHP-FPM + MySQL + GD + Imagick + PostgreSQL + SQLite3
```bash
apt install php7.0-fpm mysql-server php7.0-gd php7.0-imagick php7.0-mysql php7.0-pgsql php7.0-sqlite3
```

## nginx
```bash
apt install nginx

nano /etc/nginx/sites-available/default

root /var/www;
index index.php index.html index.htm

# Uncomment location ~\.php$ {
# Uncomment include snippets/fastcgi-php.conf;
# Uncomment and change (PHP7) fastcgi_pass unix:/var/run/php/php7.0-fpm.sock

service nginx reload

chown www-data:www-data /var/www
chmod g+w /var/www
```

## pip
```bash
wget https://bootstrap.pypa.io/get-pip.py
python get-pip.py
```

## virtualenvwrapper
```bash
nano ~/.bashrc

# virtualenvwrapper
export WORKON_HOME=~/.virtualenvs
mkdir -p $WORKON_HOME
source /usr/local/bin/virtualenvwrapper.sh
```

## Python 3.5
http://www.extellisys.com/articles/python-on-debian-wheezy

```bash
apt install build-essential
apt install libncurses5-dev libncursesw5-dev libreadline6-dev
apt install libdb5.3-dev libgdbm-dev libsqlite3-dev libssl-dev
apt install libbz2-dev libexpat1-dev liblzma-dev zlib1g-dev

wget https://www.python.org/ftp/python/3.5.1/Python-3.5.1.tgz
tar -xvzf Python-3.5.1.tgz
cd Python-3.5.1/

./configure --prefix=/opt/python-3.5.1
make
make install
```

## Locales
```bash
dpkg-reconfigure locales
locale -a
```

## Gettext
```bash
apt install gettext
```

## Redis
```bash
apt install redis-server
```

## ClamAV
```bash
apt install clamav clamav-freshclam
```

## Elasticsearch
```bash
wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
nano /etc/apt/sources.list

# Elasticsearch
deb http://packages.elastic.co/elasticsearch/1.7/debian stable main

apt update
apt install openjdk-8-jre-headless elasticsearch
```

## PostgreSQL
```bash
nano /etc/apt/sources.list.d/pgdg.list

deb http://apt.postgresql.org/pub/repos/apt/ jessie-pgdg main

wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | \
  sudo apt-key add -

apt update
apt install postgresql-9.5 postgresql-contrib-9.5 postgresql-server-dev-9.5
```

## Python libs
### MySQL
```bash
apt install libmysqlclient-dev python-dev
```

### Pillow (jpeg, tiff, ...):
```bash
apt install libtiff5-dev libjpeg62-turbo-dev zlib1g-dev libfreetype6-dev liblcms2-dev libwebp-dev tcl8.5-dev tk8.5-dev
```

### CURL
```bash
apt install libcurl4-openssl-dev
```

## Rescue
https://www.scaleway.com/docs/perform-rescue-action-on-my-server/

```bash
mkdir -p /mnt/volume0
mount /dev/nbd0 /mnt/volume0
```
