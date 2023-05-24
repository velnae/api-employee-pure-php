# Utiliza una imagen base de PHP
FROM php:7.2-fpm-stretch

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia los archivos PHP de la carpeta actual al contenedor
COPY . /var/www/html

# Expone el puerto 80 para que pueda ser accesible desde el host
EXPOSE 8080

# Inicia el servidor web PHP incorporado
CMD ["php", "-S", "0.0.0.0:8080"]

# Define un volumen que mapea al directorio actual
VOLUME ["/var/www/html"]