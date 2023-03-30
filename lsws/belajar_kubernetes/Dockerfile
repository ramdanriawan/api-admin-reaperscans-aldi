# FROM node:16
# WORKDIR /usr/src/app
# COPY package*.json ./
# RUN npm install
# EXPOSE 8080
# COPY . .
# CMD [ "node", "server.js" ]

FROM php
WORKDIR /usr/src/app
COPY ./sites /app
COPY ./lsws/bash /home
ENTRYPOINT [ "/bin/sh", "/home/composer-install.bash"]
