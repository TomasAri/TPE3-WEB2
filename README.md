PROYECTO: Venta de Zapatillas.

Integrantes:
-Arias Tomas 
-Murrone Federico

Descripcion:
Esta API te permite consultar detalles sobre Fabricas y Modelos de zapatillas, ademas si un administrador este logueado podra ademas de ver podra hacer cambios y/o agregar una nueva Fabrica o Modelo.

URL EJEMPLO:
./api/endpoint/:ID/:subrecurso

ENDPOINTS: 
- GET /api/fabrica
- GET /api/modelo

    -Devuelve todos las fabricas o modelos disponibles en la db, esta se puede aplicar un filtro por pais en el caso de fabrica y por nombres en caso de modelo. Ademas pse puede ordenar por los diferentes campos.
  
-Filtrado /api/fabrica?pais=Alemania.
-Filtrado /api/modelo?nombre=Air Jordan.

  Ordenamiento fabrica:
    orderBy: Este campo ordena los resultados de forma ascendente que es el por defecto.
    
      Las FABRICAS se pueden ordenar por cualquiera de sus campos:
      -id
      -nombre
      -importador
      -pais
      -cantidad
      
  orderBy api/fabrica?orderBy=cantidad
  
  Direction: Este campo permite ordenar de forma descendente utilizando DESC.
  
  api/fabrica?orderBy=cantidad&Direction=DESC

  Ordenamiento modelo:
    orderBy: Este campo ordena los resultados de forma ascendente que es el por defecto
    
      Las FABRICAS se pueden ordenar por cualquiera de sus campos:
      -id_zapatilla
      -nombre
      -id_fabrica
      -precio
      -stock
      
  orderBy api/modelo?orderBy=stock
  
  Direction: Este campo permite ordenar de forma descendente utilizando DESC.
  api/modelo?orderBy=stock&Direction=DESC


  Paginacion:
  
  Permite dividir los resultados en mas paginas pequeñas.
  
    pagina: numero de pagina solicitada.
    limite: numero de boletos por pagina.
    
  Paginacion api/fabrica?pais=Estados unidos&orderBy=nombre&Direction=DESC&items=2&pagina=1

- GET api/fabrica/:ID
- GET api/modelo/:ID
  Te muestra la fabrica o modelo con el id solicitado.

-POST api/fabrica
  Inserta una nueva Fabrica con informacion proporcionada en el cuerpo de solicitud. 
  
  ejemplo:
  {
    "nombre": "Nikee",
    "importador": "Jhonatan Moser",
    "pais": "Estados Unidos",
    "cantidad": 60
  }
  
-POST api/modelo
  Inserta un nuevo modelo con informacicon proporcionada en el cuerpo de la solicitud.
  
  ejemplo:
  {
    "id_zapatilla": 9,
    "id_fabrica": 1,
    "precio": 140,
    "nombre": "Air Jordan",
    "stock": 15
  }

-PUT api/fabrica/:ID
  Modifica la fabrica con el id correspondiente, la modificacion se envia en el cuerpo de solicitud.
  
  ejemplo:  
  {
    "nombre": "Puma",
    "importador": "Jhonatan Moser",
    "pais": "Estados Unidos",
    "cantidad": 70
  }
  
-PUT api/modelo/:ID
  Modifica el modelo con el id correspondiente, la modificacion se envia en el cuerpo de solicitud. 
  
  ejemplo: 
  {
    "id_zapatilla": 9,
    "id_fabrica": 1,
    "precio": 90,
    "nombre": "Air Jordan",
    "stock": 55
  }

-DELETE api/fabrica/:ID
  Elimina la fabrica con el id correspondiente.
  
-DELETE api/modelo/:ID
  Elimina el modelo con el id correspondiente.

Autenticacion
  Para acceder a ciertos privilegios el usuario debe autenticarse utilizando un token.
  
    -GET api/usuarios/token
      Este endpoin permite a los usuarios obtener un token JWT. Para utilizarlo, se deben enviar las credenciales en el encabezado de la solicitud en formato Base64
      
        -iniciar sesion:
        Nombre de usuario: webadmin
        Contraseña: admin
        
      Esto hara que te devuelva un token JWT que puede ser utilizado para autenticar futuras solicides a la APi.
