FROM ubuntu:20.04
#
# Liberally stolen from the incredible Snipe-IT project
# https://github.com/snipe/snipe-it/blob/master/Dockerfile
#
RUN export DEBIAN_FRONTEND=noninteractive; \
    export DEBCONF_NONINTERACTIVE_SEEN=true; \
    echo 'tzdata tzdata/Areas select Etc' | debconf-set-selections; \
    echo 'tzdata tzdata/Zones/Etc select UTC' | debconf-set-selections; \
    apt-get update -qqy \
 && apt-get install -qqy --no-install-recommends \
apt-utils \
apache2 \
apache2-bin \
libapache2-mod-php7.4 \
php7.4-curl \
php7.4-ldap \
php7.4-mysql \
php7.4-gd \
php7.4-xml \
php7.4-mbstring \
php7.4-zip \
php7.4-bcmath \
patch \
curl \
wget  \
vim \
git \
cron \
mysql-client \
supervisor \
cron \
gcc \
make \
autoconf \
libc-dev \
pkg-config \
libmcrypt-dev \
php7.4-dev \
ca-certificates \
unzip \
&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN curl -L -O https://github.com/pear/pearweb_phars/raw/master/go-pear.phar
RUN php go-pear.phar

RUN pecl install mcrypt-1.0.3

RUN bash -c "echo extension=/usr/lib/php/20190902/mcrypt.so > /etc/php/7.4/mods-available/mcrypt.ini"

RUN phpenmod mcrypt
RUN phpenmod gd
RUN phpenmod bcmath

RUN sed -i 's/variables_order = .*/variables_order = "EGPCS"/' /etc/php/7.4/apache2/php.ini
RUN sed -i 's/variables_order = .*/variables_order = "EGPCS"/' /etc/php/7.4/cli/php.ini

RUN useradd -m --uid 1000 --gid 50 docker

COPY . /var/www/html
WORKDIR /var/www/html

COPY docker/docker.env /var/www/html/.env

RUN chown -R docker /var/www/html

#global install of composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Get dependencies
USER docker
RUN composer install --no-dev --working-dir=/var/www/html
