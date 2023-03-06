# Original script from Ric Harvey <ric@ngd.io>

FROM php:fpm-alpine3.15

LABEL maintainer="Stoney Eagle <stoney@nomercy.tv>"

ENV php_ini /usr/local/etc/php/php.ini
ENV php_conf /usr/local/etc/php-fpm.conf
ENV fpm_conf /usr/local/etc/php-fpm.d/www.conf
ENV php_vars /usr/local/etc/php/conf.d/docker-vars.ini

ENV NGINX_VERSION 1.21.6
ENV LUA_MODULE_VERSION 0.10.14
ENV DEVEL_KIT_MODULE_VERSION 0.3.0
ENV GEOIP2_MODULE_VERSION 3.2
ENV LUAJIT_LIB /usr/lib
ENV LUAJIT_INC /usr/include/luajit-2.1

# resolves #166
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php
RUN apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/community gnu-libiconv

RUN mkdir -p /etc/nginx/modules

RUN GPG_KEYS=B0F4253373F8F6F510D42178520A9993A1C052F8 \
  && CONFIG="\
    --prefix=/etc/nginx \
    --sbin-path=/usr/sbin/nginx \
    --modules-path=/usr/lib/nginx/modules \
    --conf-path=/etc/nginx/nginx.conf \
    --error-log-path=/var/log/nginx/error.log \
    --http-log-path=/var/log/nginx/access.log \
    --pid-path=/var/run/nginx.pid \
    --lock-path=/var/run/nginx.lock \
    --http-client-body-temp-path=/var/cache/nginx/client_temp \
    --http-proxy-temp-path=/var/cache/nginx/proxy_temp \
    --http-fastcgi-temp-path=/var/cache/nginx/fastcgi_temp \
    --http-uwsgi-temp-path=/var/cache/nginx/uwsgi_temp \
    --http-scgi-temp-path=/var/cache/nginx/scgi_temp \
    --user=root \
    --group=root \
    --with-http_ssl_module \
    --with-http_realip_module \
    --with-http_addition_module \
    --with-http_sub_module \
    --with-http_dav_module \
    --with-http_mp4_module \
    --with-http_gunzip_module \
    --with-http_gzip_static_module \
    --with-http_random_index_module \
    --with-http_secure_link_module \
    --with-http_stub_status_module \
    --with-http_auth_request_module \
    --with-http_xslt_module=dynamic \
    --with-http_image_filter_module=dynamic \
    --with-http_perl_module=dynamic \
    --with-threads \
    --with-stream \
    --with-stream_ssl_module \
    --with-stream_ssl_preread_module \
    --with-stream_realip_module \
    --with-http_slice_module \
    --with-mail \
    --with-mail_ssl_module \
    --with-compat \
    --with-file-aio \
    --with-http_v2_module \
    --with-cc-opt='-Wimplicit-fallthrough=0' \
    --with-debug \
  " \
  && addgroup -S nginx \
  && adduser -D -S -h /var/cache/nginx -s /sbin/nologin -G nginx nginx \ 
  && apk add --no-cache --virtual .build-deps \
    autoconf \
    gcc \
    libc-dev \
    make \
    libressl-dev \
    pcre-dev \
    linux-headers \
    curl \
    gnupg \
    libxslt-dev \
    gd-dev \
    libmaxminddb-dev \
    perl-dev \
    luajit-dev \
  && curl -fSL http://nginx.org/download/nginx-$NGINX_VERSION.tar.gz -o nginx.tar.gz \
  && curl -fSL http://nginx.org/download/nginx-$NGINX_VERSION.tar.gz.asc -o nginx.tar.gz.asc \
  && curl -fSL https://github.com/simpl/ngx_devel_kit/archive/v$DEVEL_KIT_MODULE_VERSION.tar.gz -o ndk.tar.gz \
  && curl -fSL https://github.com/openresty/lua-nginx-module/archive/v$LUA_MODULE_VERSION.tar.gz -o lua.tar.gz \
  && export GNUPGHOME="$(mktemp -d)" \
  && found=''; \
  for server in \
    ha.pool.sks-keyservers.net \
    hkp://keyserver.ubuntu.com:80 \
    hkp://p80.pool.sks-keyservers.net:80 \
    pgp.mit.edu \
  ; do \
    echo "Fetching GPG key $GPG_KEYS from $server"; \
    gpg --keyserver "$server" --keyserver-options timeout=10 --recv-keys "$GPG_KEYS" && found=yes && break; \
  done; \
  test -z "$found" && echo >&2 "error: failed to fetch GPG key $GPG_KEYS" && exit 1; \
  gpg --batch --verify nginx.tar.gz.asc nginx.tar.gz \
  && mkdir -p /usr/src \
  && tar -zxC /usr/src -f nginx.tar.gz \
  && tar -zxC /usr/src -f ndk.tar.gz \
  && tar -zxC /usr/src -f lua.tar.gz \
  && cd /usr/src/nginx-$NGINX_VERSION \
  && ./configure $CONFIG --with-debug \
  && make -j$(expr $(nproc) \+ 1) \
  && mv objs/nginx objs/nginx-debug \
  && mv objs/ngx_http_xslt_filter_module.so objs/ngx_http_xslt_filter_module-debug.so \
  && mv objs/ngx_http_image_filter_module.so objs/ngx_http_image_filter_module-debug.so \
  && mv objs/ngx_http_perl_module.so objs/ngx_http_perl_module-debug.so \
  && ./configure $CONFIG \
  && make -j$(expr $(nproc) \+ 1) \
  && make install \
  && rm -rf /etc/nginx/html/ \
  && mkdir /etc/nginx/conf.d/ \
  && mkdir -p /var/www/html/ \
  && install -m644 html/index.html /var/www/html/ \
  && install -m644 html/50x.html /var/www/html/ \
  && install -m755 objs/nginx-debug /usr/sbin/nginx-debug \
  && install -m755 objs/ngx_http_xslt_filter_module-debug.so /usr/lib/nginx/modules/ngx_http_xslt_filter_module-debug.so \
  && install -m755 objs/ngx_http_image_filter_module-debug.so /usr/lib/nginx/modules/ngx_http_image_filter_module-debug.so \
  && install -m755 objs/ngx_http_perl_module-debug.so /usr/lib/nginx/modules/ngx_http_perl_module-debug.so \
  && ln -s ../../usr/lib/nginx/modules /etc/nginx/modules \
  && strip /usr/sbin/nginx* \
  && strip /usr/lib/nginx/modules/*.so \
  && rm -rf /usr/src/nginx-$NGINX_VERSION \
  \
  && apk add --no-cache --virtual .gettext gettext \
  && mv /usr/bin/envsubst /tmp/ \
  \
  && runDeps="$( \
    scanelf --needed --nobanner /usr/sbin/nginx /usr/lib/nginx/modules/*.so /tmp/envsubst \
      | awk '{ gsub(/,/, "\nso:", $2); print "so:" $2 }' \
      | sort -u \
      | xargs -r apk info --installed \
      | sort -u \
  )" \
  && apk add --no-cache --virtual .nginx-rundeps $runDeps \
  && apk del .build-deps \
  && apk del .gettext \
  && mv /tmp/envsubst /usr/local/bin/ \
  \
  # forward request and error logs to docker log collector
  && ln -sf /dev/stdout /var/log/nginx/access.log \
  && ln -sf /dev/stderr /var/log/nginx/error.log

RUN echo @testing http://nl.alpinelinux.org/alpine/edge/testing >> /etc/apk/repositories && \
    echo /etc/apk/respositories && \
    apk update && apk upgrade &&\
    apk add --no-cache \
    augeas-dev \
    autoconf \
    bash \
    bzip2-dev \
    ca-certificates \
    curl \
    dialog \
    docker \
    freetype-dev \
    cmake \
    gcc \
    git \
    gmp \
    gmp-dev \
    htop \
    icu-dev \
    imagemagick \
    imap-dev \
    libcurl \
    libffi-dev \
    libjpeg-turbo-dev \
    openjpeg \
    libmcrypt-dev \
    libpng-dev \
    libpq \
    libressl-dev \
    libwebp-dev \
    libxslt-dev \
    libzip-dev \
    linux-headers \
    build-base \
    automake \
    make \
    autoconf \
    musl-dev \
    nano \
    npm \
    openssh-client \
    openssl-dev \
    postgresql-dev \
    libtool \
    libvorbis-dev \
    texinfo \ 
    py3-pip \
    sqlite-dev \
    sysstat \
    supervisor \
    yarn \
    zlib \
    wget

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \
    docker-php-ext-install pdo_mysql pgsql pdo_pgsql mysqli gd exif intl xsl soap zip opcache pcntl gmp && \
    pecl install -o -f redis && \
    docker-php-source delete

RUN mkdir -p /etc/nginx && \
    mkdir -p /run/nginx && \
    mkdir -p /var/log/supervisor && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --install-dir=/usr/bin --filename=composer && \
    rm composer-setup.php

ENV CRYPTOGRAPHY_DONT_BUILD_RUST=1

ADD conf/supervisord.conf /etc/supervisord.conf

# Copy our nginx config
RUN rm -Rf /etc/nginx/nginx.conf
ADD conf/nginx.conf /etc/nginx/nginx.conf

# nginx site conf
RUN mkdir -p /etc/nginx/sites-available/ && \
mkdir -p /etc/nginx/sites-enabled/ && \
mkdir -p /etc/nginx/modules-enabled/ && \
mkdir -p /etc/nginx/ssl/

ADD conf/nginx-site.conf /etc/nginx/sites-available/default.conf
RUN ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

RUN wget https://github.com/BtbN/FFmpeg-Builds/releases/download/latest/ffmpeg-master-latest-linux64-gpl.tar.xz
RUN tar -xf ffmpeg-master-latest-linux64-gpl.tar.xz
RUN cp ffmpeg-master-latest-linux64-gpl/bin/ffmpeg /usr/bin/ffmpeg
RUN cp ffmpeg-master-latest-linux64-gpl/bin/ffprobe /usr/bin/ffprobe
RUN chmod +x /usr/bin/ffmpeg /usr/bin/ffprobe

# tweak php-fpm config
RUN sed -i \
        -e "s/;catch_workers_output\s*=\s*yes/catch_workers_output = yes/g" \
        -e "s/pm.max_children = 5/pm.max_children = 40/g" \
        -e "s/pm.start_servers = 2/pm.start_servers = 6/g" \
        -e "s/pm.min_spare_servers = 1/pm.min_spare_servers = 4/g" \
        -e "s/pm.max_spare_servers = 3/pm.max_spare_servers = 40/g" \
        -e "s/;pm.max_requests = 200/pm.max_requests = 500/g" \
        -e "s/user = www-data/user = nginx/g" \
        -e "s/group = www-data/group = nginx/g" \
        -e "s/;listen.mode = 0660/listen.mode = 0666/g" \
        -e "s/;listen.owner = www-data/listen.owner = nginx/g" \
        -e "s/;listen.group = www-data/listen.group = nginx/g" \
        -e "s/listen = 127.0.0.1:9000/listen = \/var\/run\/php-fpm.sock/g" \
        -e "s/^;clear_env = no$/clear_env = no/" \
        ${fpm_conf}

        
ARG POST_MAX_SIZE=2G
ARG MEMORY_LIMIT=2G
ARG MAX_FILE_UPLOADS=10
ARG UPLOAD_MAX_FILESIZE=5G
ARG MAX_EXECUTION_TIME=0

RUN echo "extension=redis.so"                                 >> ${php_ini} && \
		echo "xdebug.default_enable   = Off"                      >> ${php_ini} && \
		echo "xdebug.profiler_enable  = Off"                      >> ${php_ini} && \
		echo "xdebug.remote_enable    = Off"                      >> ${php_ini} && \
		echo "xdebug.remote_autostart = Off"                      >> ${php_ini} && \
    echo "cgi.fix_pathinfo        = 0"                        >> ${php_ini} && \
    echo "upload_max_filesize     = ${UPLOAD_MAX_FILESIZE}"   >> ${php_ini} && \
    echo "post_max_size           = ${POST_MAX_SIZE}"         >> ${php_ini} && \
    echo "variables_order         = \"EGPCS\""                >> ${php_ini} && \
    echo "memory_limit            = ${MEMORY_LIMIT}"          >> ${php_ini} && \
    echo "max_file_uploads        = ${MAX_FILE_UPLOADS}"      >> ${php_ini} && \
    echo "request_terminate_timeout = ${MAX_EXECUTION_TIME}"  >> ${php_ini} && \
    echo "fastcgi_read_timeout    = ${MAX_EXECUTION_TIME}"    >> ${php_ini} && \
    echo "max_execution_time      = ${MAX_EXECUTION_TIME}"    >> ${php_ini}

ADD conf/start.sh /start.sh
RUN chmod 755 /start.sh

ARG NUMENCODERS=1

RUN sed -i \
  -e "s/___NUMENCODERS___/${NUMENCODERS}/g" \
  /etc/supervisord.conf

EXPOSE 80

WORKDIR "/var/www/html"

RUN sed -i -e 's/\r$//' /start.sh
RUN sed -i -e 's/\r$//' /etc/supervisord.conf

RUN (crontab -l ; echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1")| crontab -

# RUN composer install

CMD ["/start.sh"]
