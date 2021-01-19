## API - TDD
    - ROJO      : make test first.
    - VERDE     : make logic code that support the test.
    - REFRACTOR : remake code to eliminate redundancy.

## PHP UNI
   
    - SUITE UNIT TEST - PRUEBAS UNITARIAS
        - Ayuda a provar pequeños bloques de cófigo
        - El código que se quiere testear se coloca 
          dentro de un método en el archivo test.unit
    
    - SUITE FEATURE TEST - PRUEBAS FUNCIONALES
        - Se utiliza para probar un "todo" por ejemplo :
          Una ruta que realiza una crecion de una entidad en la DB
          Esta accede a una ruta, por ende accede a un controllador 
          y este a su ves accede a un form request y a un modelo.

        - Para este caso se utiliza una prueba funcional que 
          abarca un todo de una de las lógicas de la aplicación.

    - Configuración inicial:
        
        - crear BD en /database : database.sqlite
        
        - configurar en /config/datadase 
                -> connections sqlite -> database' => database_path('database.sqlite'),

        - en phpunit.xml descomentar la conecion y la memoria
        

## CREACIÓN DEL TEST

    - FEATURE TEST:
        <pre>php artisan make:test NameTest</pre>
    
    - UNIT TEST:
        <pre>php artisan make:test NameTest --unit</pre>

    - CORRER LAS PRUEBAS
        <pre>php artisan test</pre>
        <pre>php vendor/phpunit/phpunit/phpunit</pre>

## TESTING HTTP

    - El testing http se realiza realizando pruebas a 
      peticiones HTTP, un jemplo de caso serían las
      API que basicamente son comunicaiones HTTP entre 
      el back-end y el front-end.

    
