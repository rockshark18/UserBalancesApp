FROM nginx:1.27.2-alpine

# copy our config
COPY ./default.conf /etc/nginx/conf.d/default.conf
# replacing the line for longer debug
RUN sed -i '/{sed-line-to-replace}/c\fastcgi_read_timeout 600;' /etc/nginx/conf.d/default.conf

WORKDIR /app
