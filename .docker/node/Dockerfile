# .docker/node/Dockerfile
FROM node:20-alpine

WORKDIR /var/www

COPY ./package.json ./package-lock.json* ./

RUN npm install

COPY . .
