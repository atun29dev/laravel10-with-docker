FROM centos:7.5.1804

# Setting environment
ENV APACHE_DOCUMENT_ROOT ${APACHE_DOCUMENT_ROOT:-/var/www/html/public}

# Adding PHP 8.1 repository
RUN yum install epel-release -y
RUN sed -i "s/metalink/#metalink/" /etc/yum.repos.d/epel.repo
RUN sed -i "s/#baseurl=http:\/\/download/baseurl=https:\/\/archives/" /etc/yum.repos.d/epel.repo
RUN yum install https://rpms.remirepo.net/enterprise/remi-release-7.rpm yum-utils -y &&  \
    yum-config-manager --enable remi-php81 && \
    yum update -y

# Installation PHP extensions
# The zlib1g-dev, libzip-dev, libpng-dev are necessary to enable both `gd` and `zip` extension
# The libicu-dev is necessary to enable `intl` extension
RUN yum install wget curl unzip crontabs zlib1g-dev libzip-dev libpng-dev libicu-dev -y

# Installation Apache
RUN yum install httpd httpd-tools -y

# Installation PHP extensions
RUN yum install php php-json php-gd php-zip php-intl php-mbstring php-pdo php-xml php-mysqlnd -y

# Configuring PHP ini
ADD ./docker/php.ini /etc/php.ini

# Installation Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Installation NodeJS
RUN curl -sL https://rpm.nodesource.com/setup_8.x | bash -
RUN yum install -y nodejs
RUN npm i -g nodemon

# Copying custom Apache configuration into container
COPY ./docker/httpd.conf /etc/httpd/conf/httpd.conf

# Cleans up the metadata and cache
RUN yum clean all

EXPOSE 80

# Disabling (commenting) out that specific PAM (Pluggable Authentication Modules) configuration
RUN sed -i -e '/pam_loginuid.so/s/^/#/' /etc/pam.d/crond

# Starting handle Cronjob in centOS
ADD ./docker/crontab_script /etc/cron.d/crontab_script
RUN chmod 0644 /etc/cron.d/crontab_script
RUN crontab /etc/cron.d/crontab_script

# Keeping container active
# Running Cronjob and Apache
CMD ["sh", "-c", "crond && httpd -D FOREGROUND"]
