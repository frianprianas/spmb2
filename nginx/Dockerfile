# Gunakan image app yang sudah kita buat sebagai sumber file
FROM spmb-app AS app_image

# Gunakan Nginx Alpine sebagai base
FROM nginx:alpine

# Copy file public (termasuk hasil build vite) dari image app ke nginx
COPY --from=app_image /var/www/public /var/www/public

# Copy konfigurasi nginx
COPY ./nginx/conf.d/app.conf /etc/nginx/conf.d/default.conf
