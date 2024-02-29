# Mate datos -API-
## Integrantes: Benjamin Villar Gonzales, Iñaki Gopar
# Descripcion:
Esta API tiene como objetivo acceder a los datos (categorias y productos) presentes en la base de datos de Mate Datos.

# Endpoints -Categoria-

## GET api/categorias 
Este endponit trae todas las categorías de la base de datos y por query params podemos filtrar los distintos
campos.
Ejemplo: podes traer todas las categorías que sean frágiles=
**api/categorias?field=fragil&value=0**.
Cada categoria se listara de la siguiente manera:
```
{
  "id_categoria": 1,
  "categoria": "Mate",
  "fragil": 1
}
```
> [!NOTE]
> Si no se especifica el filtro se mostraran todas las categorias.
> En el campo fragil utilizar 0 o 1 para indicar true o false.

## GET api/categorias/:ID
Este endponit devuelve la categoría indicada en el id.

## POST api/categorias
Este endponit recibe un objeto JSON con los datos de la categoría a agregar:
En el body se debera mandar el objeto JSON de la siguiente manera:
```
{
  “categoria”:” "Mate",
  “fragil”: 0
}
```

Si la categoría fue insertada correctamente se mostrara el siguiente mensaje:
“mensaje”: “la categoría con el id=x fue insertada exitosamente”.
> [!NOTE]
> Aclaracion: este endponit se podrá utilizar siempre y cuando se haga la validación token con éxito,
> Caso contrario se mostrara un mensaje del tipo Unauthorized 401 el cual te informa que
> no tenes permisos suficientes.

## DELETE api/categorias/:ID
Este endpoint elimina la categoría con el id indicado.
De haberse realizado con éxito se mostrara un mensaje del tipo:
“mensaje”: “la categoría con el id=x fue eliminado exitosamente”.

> [!NOTE]
> No se puede borrar una categoría que tenga productos cargados, en el caso de intentarlo se
> mostrara un mensaje de error.

> [!IMPORTANT]
> Este endponit se podrá utilizar siempre y cuando se haga la validación token con éxito,
> Caso contrario se mostrara un mensaje del tipo Unauthorized 401 el cual te informa que
> no tenes permisos suficientes.

## PUT api/categorías/:ID
Este endpoint recibe un objeto JSON con las modificaciones de la categoría del id recibido y lo
modifica mostrando el siguiente mensaje “mensaje”: “la categoría fue modificada con exito”.
```
{
“categoria”: ”dato_modificado",
“fragil”: dato_modificado
}
```
> [!IMPORTANT]
> Este endponit se podrá utilizar siempre y cuando se haga la validación token con éxito,
> Caso contrario se mostrara un mensaje del tipo Unauthorized 401 el cual te informa que
> no tenes permisos suficientes.


# Endpoints -Productos-

## GET api/productos
Este endponit trae todas los productos de la base y por query params podemos ordenar los
distintos productos en base a un determinado campo y si es ascendente o descendente.
Los productos se mostraran de la siguiente manera:

```
{
    "id_producto": 1,
    "id_categoria": 1,
    "nombre": "Mate",
    "material": "Cuero",
    "color": "Marron",
    "precio": 10000
}

```

> [!NOTE]
> En caso de no recibir métodos de ordenamiento por defecto se mostraran ordenados por el
> campo precio de manera ascendentemente.
> A la hora de definir su forma de ordenamiento tener en cuenta que ascendente = ASC y
> descendete = DESC.
> Ejemplo: podes traer todos los productos ordenados por color descendentemente
> **api/productos?field=color&order=DESC**.
> Tener en cuenta que algunos campos estan cargados con mayusculas y otros con minusculas por lo que el ordenamiento va a dar prioridad a las minusculas y luego a las mayusculas.


## GET api/productos/:ID
Este endponit devuelve el producto indicado en el id recibido.

## POST api/productos
Este endponit recibe un objeto JSON con los datos del producto a agregar.
En el body se debera mandar el objeto JSON de la siguiente manera:
```
{
  "id_categoria": 1,
  "nombre": "Mate",
  "material": "Cuero",
  "color": "Marron",
  "precio": 10000
}
```
Si el producto fue insertadao correctamente se mostrara el siguiente mensaje:
“mensaje”: “el producto con el id=x fue insertado exitosamente”.

> [!IMPORTANT]
> Este endponit se podrá utilizar siempre y cuando se haga la validación token con éxito,
> Caso contrario se mostrara un mensaje del tipo Unauthorized 401 el cual te informa que
> no tenes permisos suficientes.


## DELETE api/productos/:ID
Este endpoint elimina el producto con el id recibido.
De haberse realizado con éxito se mostrara un mensaje del tipo:
“mensaje”: “la categoría con el id=x fue eliminado exitosamente”.

> [!IMPORTANT]
> Este endponit se podrá utilizar siempre y cuando se haga la validación token con éxito,
> Caso contrario se mostrara un mensaje del tipo Unauthorized 401 el cual te informa que
> no tenes permisos suficientes.


## PUT api/productos/:ID
Este endpoint recibe un objeto JSON con las modificaciones del producto con el id recibido y lo
modifica mostrando el siguiente mensaje “mensaje”: “el producto fue modificado con exito”.

```
{
  "id_categoria": 1,
  "nombre": "nombre_modificado",
  "material": "material_modificado",
  "color": "color_modificado",
  "precio": precio_modificado
}
```

> [!IMPORTANT]
> Este endponit se podrá utilizar siempre y cuando se haga la validación token con éxito,
> Caso contrario se mostrara un mensaje del tipo Unauthorized 401 el cual te informa que
> no tenes permisos suficientes.

> [!NOTE]
> En caso de ingresar un id_categoria no existente tirara un error.



# Endpoints -Usuario-

## GET api/usuario/token
Este endponit verifica si el usuario esta logueado en la base de datos, de ser asi crea un token para
utilizarlo en los endpoints que lo requieren. (DELETE, POST, PUT). En caso de que el usuario no
este logueado no se le brindara ningún token por lo tanto no podra realizar las acciones mencionadas.

> [!NOTE]
>Este mismo deberá agregarse a los headers del request de la siguiente manera:
> Authorization: Bearer <token generado>.

> [!IMPORTANT]
> Para recibir el token se deberá ingresar el siguiente usuario y contraseña:
> Usuario = webadmin.
> Contraseña = admin.
