FROM node:14.11.0-alpine3.11 AS builder

WORKDIR /app

COPY package* ./
COPY yarn.lock ./

RUN ["yarn"]

# Runtime image from here
FROM node:14.11.0-alpine3.11 AS prod

WORKDIR /app

# Copy node_modules from builder image
COPY --from=builder /app .
ADD ./app.js /app

CMD ["yarn", "run", "start"]

EXPOSE 1357