
    crear model Marca
    crear migracion create_marcas_table
            editar la migración
    ejecutar migración

    // un seeder es una clase para insertar datos
    crear seeder MarcaSeeder
    ejecutar seeder

    crear un controller MarcaController

*    php artisan make:model Marca  
     php artisan make:migration create_marcas_table  
     php artisan make:seeder MarcaSeeder  
*    php artisan make:controller MarcaController -r  

    php artisan make:model Marca -mcrs
    

    php artisan db:seed --class=MarcaSeeder
    
----
    php artisan make:model Categoria -mcrs
    php artisan db:seed --class=CategoriaSeeder
    
    php artisan make:model Producto -mcrs
  
    migraciones marcas, categorias, productos
    modelos marcas, categorias, productos
    controladores marcas, categorias, productos
