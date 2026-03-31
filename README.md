# Respuestas al Examen TFG - Proyecto CodaERP

A continuación presento las respuestas a las preguntas del examen, basándome directamente en el desarrollo de mi aplicación (que he llamado **CodaERP** para este proyecto).

---

## BLOQUE 1: API y Seguridad

### 1. Demostrar la comunicación entre sistemas preparando mecanismos (API)
Para demostrar esto en mi proyecto, he montado un esquema donde el "frontend" (lo que se ve en el navegador) y el "backend" (el servidor que procesa todo) son sistemas completamente separados. Se comunican mediante peticiones HTTP. Cuando creas un cliente nuevo en mi aplicación, el formulario **no recarga la página**; en su lugar, coge los datos, los convierte a formato JSON y los envía por detrás mediante un `fetch (POST)` a la ruta `/api/clientes` del servidor.

### 2. Rol de servidor y rol de cliente
En mi arquitectura, el **Cliente** es el navegador de internet ejecutando JavaScript. Su única misión es pintar la interfaz (HTML/CSS), capturar los clics del usuario y mandar peticiones de datos. 
El **Servidor**, que he programado en PHP, funciona como el "cerebro" centralizado. No sabe nada de colores ni botones; simplemente escucha en los endpoints, hace las validaciones de seguridad, guarda o saca cosas de la base de datos y le devuelve un JSON limpio al cliente con la información solicitada.

### 3. Apertura de un servicio web (API) y contrato
He diseñado mi aplicación de forma que no sea un sistema cerrado. He abierto un servicio web RESTful para que, si el día de mañana queremos conectar una aplicación móvil o un software externo, puedan hacerlo. El **"contrato"** son las reglas que he definido para que nos entendamos: qué rutas existen (por ejemplo `GET /api/clientes`), qué cabeceras hay que mandar para autorizarse, y exactamente cómo será el JSON que yo les voy a devolver si todo va bien o si hay un error.

### 4. Técnicas criptográficas de ida y vuelta
He implementado en mi software un sistema para guardar datos confidenciales, como si tuviéramos que almacenar los tokens de acceso de otros proveedores. Para ello uso **criptografía simétrica (AES-256)**. Esto significa que cuando el usuario mete un dato sensible, el servidor lo cifra usando una clave secreta que solo yo tengo en mi archivo de configuración. Cuando el servidor necesita volver a leerlo para enviarlo a un proveedor, usa la misma clave para **desencriptarlo y recuperar el texto original completo**.

### 5. Técnicas de hasheado
A diferencia de la encriptación anterior, para las contraseñas de los usuarios he usado funciones de "Hash" (como **Bcrypt** o SHA-256). Esto es vital porque el hash es un proceso destructivo. Cuando un usuario se registra, la aplicación destroza la contraseña matemáticamente y solo guarda la huella resultante. **Es imposible recuperar la contraseña original a partir del hash**. Cuando el usuario intenta entrar, simplemente vuelvo a hashear lo que ha escrito y compruebo si la huella coincide con la que tengo guardada. 

---

## BLOQUE 2: Arquitectura y Sistema de Gestión

### 1. Tipos de sistema de gestión empresarial
Existen varios tipos principales dependiendo de qué área de la empresa ataquen. Los más habituales son los **ERP** (que enlazan todas las partes vitales centralizando contabilidad, stock y recursos), los **CRM** (enfocados a marketing y relación con los clientes), los **SGA** (para el control de almacenes y logística pura), y los **SGRH** (recursos humanos).

### 2. Clasificación de mi software
He enfocado mi proyecto como un **CRM (Customer Relationship Management)** integrado dentro de la base de lo que sería un mini-ERP clásico. Lo clasifico así porque su eje central es la tabla de clientes segmentados, conectada directamente con el registro transaccional de ventas o pedidos.

### 3. Gestor de base de datos y por qué
He decidido utilizar **SQLite** para este proyecto. Lo he elegido principalmente por su tremenda portabilidad. A diferencia de MySQL o PostgreSQL que necesitan levantar un servicio pesado en la máquina, SQLite es un motor embebido. Me crea un único archivo físico donde guarda todas las tablas, relaciones e índices, pero me sigue permitiendo utilizar claves foráneas, restricciones y todo el estándar SQL sin problemas, lo cual era perfecto para poder llevar el proyecto de un lado a otro.

### 4. Operaciones de documentación de la aplicación
La aplicación tiene varias formas de documentar las cosas: a nivel de código he separado claramente los endpoints de la API de la capa de base de datos. A nivel funcional, cualquier cambio importante en el sistema debe ir a una tabla de trazabilidad (auditoría), y además he creado **una pestaña dentro de la propia aplicación web dedicada puramente a documentar el contrato de la API** para terceros desarrolladores.

### 5. Módulos del sistema y estructura
He programado el backend de forma muy modular para que no sea un bloque de código infumable. 
* Por un lado tengo el **módulo de base de datos** (`database.php`) encargado exclusivamente de conectar y lanzar consultas. 
* Por otro, tengo el **enrutador o API Gateway** (`index.php`), que es el portero de discoteca y decide a dónde va cada petición web. 
* Luego, la **lógica dura** está separada en pequeños módulos (`clientes.php`, `seguridad.php`). 
Lo estructuré así para poder ampliar o modificar un apartado sin que el resto del sistema corra peligro de romperse.

### 6. Parámetros configurables
He extraído cualquier valor "sensible" o cambiante del código fuente y lo he metido en un único archivo **`config.php`**. Ahí defino cosas como en qué entorno estoy trabajando, cuál es el nombre de la web, y sobre todo, ahí guardo **la clave secreta y el vector de inicialización de la encriptación AES**. Lo hago por seguridad, y porque si cambio el software de servidor, solo tengo que tocar un archivo central para que todo se adapte.

### 7. Interoperabilidad (Entradas y Salidas)
Sí, la herramienta está preparada para hablar con otros sistemas gracias a la API que he construido. 
* De **entrada**, mi aplicación expone rutas POST donde otra aplicación podría mandarme un JSON con los datos de una venta o un alta nueva, y mi sistema lo integraría automáticamente. 
* De **salida**, externalizo todas mis tablas por rutas GET, de modo que si dirección comprase un software como PowerBI, estos podrían leer instantáneamente mi inventario o mis estadísticas consultando esos endpoints en tiempo real.

### 8. Entornos de desarrollo y tecnologías
A nivel de sistema operativo estoy trabajando sobre un entorno de Linux basado en Arch (**CachyOS**). Como motor principal en el servidor uso **PHP 8.x** interactuando mediante su servidor nativo. En el frontend u ordenador del cliente, toda la estructura está programada puramente a mano con **HTML5, CSS3** usando variables para el modo oscuro, y **Vanilla JavaScript** gestionando el DOM de forma reactiva, además de la librería **Chart.js**.

### 9. Tablas y campos de la base de datos
He diseñado una estructura transaccional clásica (estrategia en estrella). Por resumirlo: 
Tengo la tabla `clientes` (con id, nombre, email, empresa, fecha y segmento). Tengo la tabla de `pedidos` (que contiene su id, el cliente asociado como clave foránea, la fecha, y su estado general). Por último, para permitir pedidos con varios productos, tengo una tabla de cruce `pedido_lineas` que relaciona el pedido en sí con cada producto, guardando el precio que costaron en ese preciso instante.

### 10. Consultas a bases de datos en la aplicación
Realizo todo el repertorio **CRUD**. Cuando abro el directorio de clientes hago una lectura global simple (`SELECT * FROM clientes`). Cuando alguien interactúa con el formulario para crear un registro, lanzo consultas de escritura (`INSERT INTO clientes VALUES (?, ?...)`). Y también lanzo consultas complejas de agregación, usando `SUM` y `GROUP BY` para calcular las ventas agrupadas por mes.

### 11. Interfaces de acceso a datos
En vez de mezclar comandos crudos de SQLite a mano en medio del código web, me comunico usando la interfaz **PDO** (PHP Data Objects). Básicamente es una capa estándar interpuesta. La mayor ventaja es que me permite hacer **"sentencias preparadas"**. En vez de pegar el texto de un formulario directo en la frase SQL, le digo al PDO que hay un hueco reservado `?`. El driver del propio lenguaje se encarga de escapar y desinfectar el texto, **bloqueando totalmente los intentos de inyección SQL**.

### 12. Informes y gráficas
Mi aplicación no muestra simples tablas, sino que convierte los datos masivos en inteligencia visual de negocio para la toma de decisiones. Lo he resuelto montando un endpoint `/api/stats` que suma los pedidos usando funciones nativas de base de datos. Una vez que mi JavaScript cliente recibe estos totales ya calculados, los paso a la librería **Chart.js** que dibuja un dashboard con gráficas de barras para ver los ingresos, y gráficos de anillos para entender visualmente qué segmento de clientes nos está comprando más.
