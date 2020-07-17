FROM nginx:1.10

ADD docker-configs/vhost.conf /etc/nginx/conf.d/default.conf
