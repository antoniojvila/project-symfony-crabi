# Proyecto Symfony con Docker

Este proyecto utiliza Symfony y Docker para facilitar el desarrollo y despliegue de aplicaciones web. A continuación, se detallan los pasos para configurar y ejecutar el proyecto.

## Requisitos

-   Docker
-   Docker Compose
-   Postman (para probar los endpoints)

## Configuración Inicial

1.  **Cambiar el nombre de las plantillas de .env:**
    
    - en el directorio root cambiar el nombre de template_docker.env por .env
    - en el directorio symfony cambiar el nombre de template.env por .env
    
2.  **Construir y levantar los contenedores:**
    
    Navega hasta el directorio donde se encuentra el archivo `docker-compose.yml` y ejecuta el siguiente comando:
    
    
    `docker-compose build`

	luego:
	`docker-compose up -d` 
    
3.  **Acceder al contenedor de Symfony:**
    
    Una vez que los contenedores estén en funcionamiento, accede al contenedor de Symfony normalmente llamado `symfony-php-apache`con:
    
    `docker exec -it symfony-php-apache bash` 
    
4.  **instalar composer:**
    
    Dentro del contenedor, ejecuta el siguiente comando para instalar dependencias :
	    `composer install` 

5.  **Migrar los modelos:**
    
    Dentro del contenedor, ejecuta los siguientes comandos para migrar los modelos:
	    `php bin/console doctrine:migrations:migrate` 
    
6. **Crear par de llaves encriptadas para jwt**
		`php bin/console lexik:jwt:generate-keypair`

## Probar Endpoints

1.  **Importar la colección de Postman:**
    
    -   Abre Postman.
    -   Importa la colección de endpoints que se encuentra en el archivo `Crabi.postman_collection.json` en tu proyecto.
2.  **Configurar variables de entorno:**
    
    Asegúrate de configurar las variables de entorno en postman (token)
    
3.  **Probar los endpoints:**
    
    Utiliza la colección importada en Postman para probar los diferentes endpoints de tu aplicación Symfony.

## Descarga de archivos

Puedes descargar el archivo [aquí](https://github.com/antoniojvila/project-symfony-crabi/blob/main/resource/Crabi.postman_collection.json).