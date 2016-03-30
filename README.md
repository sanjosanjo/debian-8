# Debian 8 install cheatsheet

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
https://www.digitalocean.com/community/tutorials/how-to-setup-a-firewall-with-ufw-on-an-ubuntu-and-debian-cloud-server

```bash
apt install ufw

nano /etc/default/ufw
IPV6=no

ufw disable
ufw enable

ufw default deny incoming
ufw default allow outgoing

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
apt-key add dotdeb.gpg

apt update
```

## MySQL
```bash
apt install mysql-server
```

## PHP-FPM + GD + Imagick + PostgreSQL + SQLite3
```bash
apt install php7.0-fpm php7.0-gd php7.0-imagick php7.0-mysql php7.0-pgsql php7.0-sqlite3
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
pip install virtualenvwrapper

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
wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | apt-key add -
nano /etc/apt/sources.list

# Elasticsearch
deb http://packages.elastic.co/elasticsearch/1.7/debian stable main

apt update

# apt install openjdk-8-jre-headless  # 2016-03-30: was not found
apt install openjdk-7-jre-headless
apt install elasticsearch
```

## PostgreSQL
```bash
nano /etc/apt/sources.list.d/pgdg.list

deb http://apt.postgresql.org/pub/repos/apt/ jessie-pgdg main

wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -

apt update
apt install postgresql-9.5 postgresql-contrib-9.5 postgresql-server-dev-9.5 postgresql-9.5-postgis-2.2
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

## unzip
```bash
apt install unzip
```

## git
```bash
apt install git
```

## Backup-Manager
http://documentation.online.net/fr/serveur-dedie/sauvegarde/sauvegarde-dedibackup#backup_manager_gnulinux

```bash
wget https://github.com/sukria/Backup-Manager/archive/master.zip -O backup-manager.zip
unzip backup-manager.zip
cd Backup-Manager-master/
make install
cp /usr/local/share/backup-manager/backup-manager.conf.tpl /etc/backup-manager.conf

nano /etc/backup-manager.conf

export BM_ARCHIVE_METHOD="tarball-incremental mysql pgsql"

BM_TARBALL_TARGETS[2]="/home"
BM_TARBALL_TARGETS[3]="/var/www"

export BM_MYSQL_ADMINPASS="secret"
export BM_MYSQL_DBEXCLUDE="information_schema"

export BM_UPLOAD_METHOD="ftp"

export BM_UPLOAD_FTP_USER="secret"
export BM_UPLOAD_FTP_PASSWORD="secret"
export BM_UPLOAD_FTP_HOSTS="secret"

nano /etc/cron.daily/backup-manager

#!/bin/sh
test -x /usr/local/sbin/backup-manager || exit 0
/usr/local/sbin/backup-manager

chmod +x /etc/cron.daily/backup-manager

/usr/local/sbin/backup-manager
```

## Rclone
http://nogues.pro/blog/backup-hubic-duplicity-rsync.html
http://rclone.org/hubic/

```bash
wget http://downloads.rclone.org/rclone-v1.28-linux-amd64.zip
unzip rclone-v1.28-linux-amd64.zip
cd rclone-v1.28-linux-amd64
cp rclone /usr/sbin/
chmod 755 /usr/sbin/rclone

rclone config

# For browser auth
apt install lynx
lynx http://127.0.0.1:53682

rclone /my/directory remote:remote-dir
```

## Rescue
https://www.scaleway.com/docs/perform-rescue-action-on-my-server/

```bash
mkdir -p /mnt/volume0
mount /dev/nbd0 /mnt/volume0
```
