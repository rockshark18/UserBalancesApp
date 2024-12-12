FROM node:lts-alpine as build-stage

WORKDIR /frontend
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# этап production (production-stage)
FROM nginx:stable-alpine as production-stage
#RUN apk update && apk add bash mc
COPY --from=build-stage /frontend/dist /usr/share/nginx/html

#настраиваем nginx без отдельного nginx.conf
RUN echo "server { listen 8080; server_name localhost; location / { root /usr/share/nginx/html; try_files \$uri \$uri/ /index.html; } }" > /etc/nginx/conf.d/default.conf

EXPOSE 8080
#запускаем nginx на 8080 порту
CMD ["nginx", "-g", "daemon off;"]

