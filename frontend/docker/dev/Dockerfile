FROM node:lts-alpine
WORKDIR /frontend
COPY package*.json ./
RUN npm install

COPY . .
#RUN find /frontend/src/assets -name "*.svg:Zone.Identifier" -type f -delete

EXPOSE 8080
CMD ["npm", "run", "dev"]

