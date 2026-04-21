# Prueba Técnica Oberstaff

Aplicación Laravel 10 con gestión de usuarios y empresas  
edición de datos de empresa y exportación a PDF.


## Instalación


git clone git@github.com:sagh31/prueba_oberstaff.git 
cd prueba_oberstaff
composer install
cp .env.example .env
php artisan key:generate



# Configurar credenciales MySQL en .env (DB_DATABASE=prueba_oberstaff)
php artisan migrate --seed
npm install && npm run build
php artisan serve




## Credenciales de prueba

- Email: `saul.guerrero2009@gmail.com`
- Password: `password`


## URL prueba tecnica funcional (En vivo)
prueba.s23app.com