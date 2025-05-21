Este es un proyecto web de música que usa tecnologías como HTML, CSS, JavaScript, PHP y bases de datos MySQL.
La base de datos contiene todas las consultas en procedimientos almacenados.
El proyecto cuenta con la sección principal en donde tiene opción de buscar canciones, y la opción con los enlaces en un desplegable para crear cuenta o iniciar sesión.
Si ya se creó la cuenta o se inicio sesión el enlace lo dirige a la cuenta creada.
En esa misma sección inicial se pueden ver todas las canciones compartidas por los usuarios, cada una contiene la imagen de la canción, el usuario que lo compartió junto con su imagen de perfil,
el reproductor de las canciones el cual es un diseño propio en el cual se puede reproducir o pausar independientemente cada canción junto con su barra de progreso.
Adicionalmente cada canción contiene la opción de agregar me gusta o no megusta y la cantidad de veces que se a reproducido, además de poder descargar dicha canción.
Esta sección principal contiene una paginación la cual divide la cantidad de canciones para no mostrar todas en una misma página.

Luego la sección de crear cuenta contiene la opción de subir la imagen de perfil la cual es opcional, la imagen de portada que también es opcional, el nombre de usuario, 
el correo, la contraseña la cual debe coincidir con el campo siguiente que es de verificación de la misma, y los usuarios de redes sociales como facebook, instagram y X.

Por el lado de iniciar sesión se tiene que ingresar el correo y la contraseña. Cada contraseña se ingresa encriptada por seguridad y adicionalmente esta sección contiene 
la opción de cambiar la contraseña en caso de olvidarla mediante un enlace que envia a otra página para ingresar el correo en el cual se enviará el enlace para cambiar la contraseña,
usa un método de verificación de usuario mediante tokens el cual tiene un tiempo limitado para cambiarla por seguridad.
Una vez que se recibe el correo mediante un enlace se puede acceder al cambio de contraseña la cual se debe ingresar dos veces, una vez cambiada, 
cumpliendo con los requisitos de la contraseña los cuales son mayusculas, minusculas , caracteres especiales y numeros, se confirma el cambio.

Existe la sección del perfil a la cual se puede acceder al propio perfil o a un perfil ajeno, si es el perfil propio se puede observar las imagenes de perfil y de portada, 
en caso de no contar con estas imagenes se muestran las imagenes por defecto, debajo el nombre de usuario y luego los enlaces a las redes sociales en caso de que tenga.
Luego está la sección de canciones en donde se muestran las canciones de dicho usuario, otra sección con la opción de subir canción en donde se elige el titulo, 
la descripción, el archivo de audio y la imagen que acompaña la canción. Por último la sección de eliminar la cuenta. Por otro lado también está la opción de cerrar sesión. 
Cada canción en esta sección del dueño se puede editar, se puede cambiar el titulo, la descripción y la imagen usada para la canción. Además de poder eliminar la canción.

Si es una cuenta ajena solo se muestra la sección de canciones, sus redes sociales y la opción de seguir al usuario, que se reemplaza por el cerrar sesión, 
que solo está disponible para el dueño de la cuenta.

Otra sección que está en la parte de perfil es la de editar la cuenta que solo está disponible para el dueño, si se accede se puede cambiar el usuario, el correo o las imagenes 
de perfil o de portada.

Contiene una sección para visualizar la canción en donde se muestran las mismas opciones de la sección principal solo que acá se puede visualizar la descripción de la canción y 
los comentarios de la misma, en donde también permite dejar un comentario. Cada comentario se puede editar o eliminar solamente si uno es el que publicó dicho comentario 
de lo contrario no permite editarlo ni eliminarlo. La sección se programó para editar el comentario en el mismo sitio de la canción, cambiando la vista entre el comentario y 
el area de texto para editarlo. Junto al comentario se puede visualizar el usuario quien comentó junto con su imagen de perfil y la fecha en la que se comentó. 
