FROM node:14.11.0-alpine3.11

WORKDIR /app

COPY package.json /app

RUN yarn

CMD ["yarn", "start"]

EXPOSE 1357