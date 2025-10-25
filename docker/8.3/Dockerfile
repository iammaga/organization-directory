FROM ubuntu:22.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=18
ARG INSTALL_NODE=true
ARG INSTALL_GIT=true
ARG INSTALL_SSH=true

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E52678EEA15E788C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && apt-add-repository "deb http://ppa.launchpad.net/ondrej/php/ubuntu jammy main" \
    && apt-get update \
    && apt-get install -y php8.3-cli php8.3-fpm php8.3-gd php8.3-mysql php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-zip php8.3-intl php8.3-soap php8.3-sqlite3 php8.3-curl \
    && apt-get install -y nginx \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN set -eux; \
    if [ ${INSTALL_NODE} = "true" ]; then \
        curl -sL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash -; \
        apt-get install -y nodejs; \
    fi;

RUN set -eux; \
    if [ ${INSTALL_GIT} = "true" ]; then \
        apt-get install -y git; \
    fi;

RUN set -eux; \
    if [ ${INSTALL_SSH} = "true" ]; then \
        apt-get install -y openssh-client; \
    fi;

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin --filename=composer

RUN groupadd --gid $WWWGROUP sail \
    && useradd -ms /bin/bash --uid 1000 --gid $WWWGROUP sail

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.3/fpm/conf.d/99-custom.ini
COPY nginx.conf /etc/nginx/sites-available/default

RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]

