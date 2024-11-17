# WEB2-TPE-3-API_REST-ENTREGA

Integrantes: -Ibarra Ivan Leonel -Ondicol Luciano Hernan

Sólo hicimos la API REST sobre una tabla (la tabla 'videojuegos') y usamos Thunder Client.

ENDPOINTS

- VERBO: GET / método: [getAll]
  * 'api/videogames' (obtener el listado de todo. Por defecto entrará en la página 1 ('api/videogames?page=1', aunque esto no se verá) y tendrá un tamaño de 5 items ('api/videogames?pageSize=5', lo cuál tampoco se verá) por página)
  * 'api/videogames?orderBy=campo&order_dir=ASC/DESC' (obtener el listado ordenado por cualquier campo, para que funcione tiene que usarse "orderBy=campo" y especificar su orden con "order_dir = ASC (ascendente) o = DESC (descendente)", si no se especifica no se ordena).
Los campos por los que se pueden ordenar son los siguientes: [id_juego; nombre; desarrollador; distribuidor; genero; fecha_lanzamiento; id_plataforma; modos_de_juego; precio]
  * 'api/videogames?id_plataforma=X' (filtra el listado de videojuegos por id_plataforma. Sólo apareceran los videojuegos que tengan el id_plataforma de la consulta.)
  * 'api/videogames?page=X&pageSize=X' (puedes indicar con 'page=X' la página en la que te quieres situar y con 'pageSize=X' la cantidad de items por página. Puedes especificar una y no la otra, por ejemplo puedes elegir cualquier página sin especificar el tamaño (será por defecto 5) o puedes cambiar el tamaño sólamente (por defecto estarás en la página 1). Lo que está por defecto no se verá.)
  * Todo esto se puede mezclar, por ejemplo usar el endpoint: 'api/videogames?id_plataforma=3&page=2&pageSize=3&orderBy=precio&order_dir=DESC'


- VERBO: GET / método: [get]
  * 'api/videogames/:id (obtendrás un videojuego por su id, por ejemplo 'api/videogames/59')



- VERBO : POST / método: [create]
  * 'api/videogames' (En el body se define un objeto JSON y al enviarlo por este endpoint, se creará una nueva tarea. Tienes que agregar todos los campos excepto 'id_juego', ya que se generará automaticamente.)


- VERBO : PUT / método: [update]
  * 'api/videogames/:id (En el body se define un objeto JSON y al enviarlo por este endpoint, se actualizará la tarea especificada por el ID por ese JSON. Lo primero que hay que hacer es obtener el videojuego por el ID y copiar todos los campose excepto 'id_juego' y pegarlos en el body, allí modificas lo que seas y lo envias para que se actualice todo.)


- VERBO : DELETE / método [delete]
  * 'api/videogames/:id' (Se especifica el ID y al enviar la consulta eliminas el item con ese ID. Ejemplo: 'api/videogames/59').


EL OBJETO JSON necesario para el POST y PUT es este (en RAW se ve mejor):
{
  "nombre": "nombre",
  "desarrollador": "desarrollador",
  "distribuidor": "distribuidor",
  "genero": "genero",
  "fecha_lanzamiento": "2024-01-01",
  "id_plataforma": 1,
  "modos_de_juego": "modos_de_juegos",
  "precio": 999
}
