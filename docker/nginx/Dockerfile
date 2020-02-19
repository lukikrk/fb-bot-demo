FROM nginx:1.16-alpine

COPY default.conf /etc/nginx/conf.d/default.conf

RUN apk add --no-cache curl \
    && curl -s -O https://bin.equinox.io/c/4VmDzA7iaHb/ngrok-stable-linux-amd64.zip \
    && unzip ngrok-stable-linux-amd64.zip \
    && mv ngrok /usr/local/bin/ \
    && rm -f ngrok-stable-linux-amd64.zip \
    && ngrok authtoken 1XJNNnG8kZsPjjFmLsYNWCC0gIo_7VpBhwTcvhiuK4o2G2jbt