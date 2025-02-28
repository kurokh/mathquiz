FROM node:20.10.0 as builder

ARG VITE_OPENAI_API_KEY
ARG VITE_BACKEND_API_URL

ENV VITE_OPENAI_API_KEY=${VITE_OPENAI_API_KEY}
ENV VITE_BACKEND_API_URL=${VITE_BACKEND_API_URL}

WORKDIR /app

RUN rm -rf node_modules

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

FROM nginx:stable-alpine
COPY --from=builder /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]