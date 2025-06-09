- **Para la base de datos**
    ✅ Para ejecutarlo
        Simplemente corre:
        php artisan db:seed

        O, si necesitas limpiar todo antes:
        php artisan migrate:fresh --seed

        php artisan session:table
        php artisan migrate

- **Ejecutar laravel**
    php artisan serve
    npm run dev

- **Dar permisos**

sudo chown -R daemon:daemon /opt/lampp/htdocs/Proyecto_admin/storage
sudo chown -R daemon:daemon /opt/lampp/htdocs/Proyecto_admin/bootstrap/cache

sudo chmod -R 775 /opt/lampp/htdocs/Proyecto_admin/storage
sudo chmod -R 775 /opt/lampp/htdocs/Proyecto_admin/bootstrap/cache

- **Configuración de VirtualHost**

/opt/lampp/etc/httpd.conf