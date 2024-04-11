FROM node:21

WORKDIR /var/www/laravel

CMD [ "npm", "install", "--save-dev laravel-echo pusher-js"]



