FROM nimmis/apache:14.04

MAINTAINER nimmis <kjell.havneskold@gmail.com>

# disable interactive functions
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
apt-get install -y telnet curl tinc php5 libapache2-mod-php5  \
php5-fpm php5-cli php5-mysqlnd php5-pgsql php5-sqlite php5-redis cronolog \
php5-apcu php5-intl php5-imagick php5-mcrypt php5-json php5-gd php5-curl && \
php5enmod mcrypt && \
rm -rf /var/lib/apt/lists/* && \
cd /tmp && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Apache configuration
RUN mkdir -p /etc/apache2/vhosts
RUN mkdir -p /etc/apache2/vhosts-ssl
COPY ./apache/vhosts/booking.techtest.com.conf /etc/apache2/vhosts/
COPY ./apache/apache2.conf /etc/apache2/
RUN ln -sf /etc/apache2/vhosts/booking.techtest.com.conf /etc/apache2/sites-enabled/000-booking.techtest.com.conf

RUN mkdir -p /var/www/booking

# Setup VPN tinc
RUN mkdir -p /etc/tinc/traqy
COPY ./vpn/tinc/* /etc/tinc/traqy/
COPY ./vpn/nets.boot /etc/tinc/

# Run entry point
COPY docker-entrypoint.sh /root/
#ENTRYPOINT /root/docker-entrypoint.sh
