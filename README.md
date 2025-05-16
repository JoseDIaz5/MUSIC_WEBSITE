Este es un proyecto web de música que usa tecnologías como HTML, CSS, JavaScript, PHP y bases de datos MySQL.
El proyecto cuenta con la sección principal en donde tiene opción de buscar canciones, y la opción con los enlaces en un desplegable para crear cuenta o iniciar sesión.
Si ya se creó la cuenta o se inicio sesión el enlace lo dirige a la cuenta creada.
En esa misma sección inicial se pueden ver todas las canciones compartidas por los usuarios, cada una contiene la imagen de la canción, el usuario que lo compartió junto con su imagen de perfil,
el reproductor de las canciones el cual es un diseño propio en el cual se puede reproducir o pausar independientemente cada canción junto con su barra de progreso.
Adicionalmente cada canción contiene la opción de agregar me gusta o no megusta y la cantidad de veces que se a reproducido.
Esta sección principal contiene una paginación la cual divide la cantidad de canciones para no mostrar todas en una misma página.

Luego la sección de crear cuenta contiene la opción de subir la imagen de perfil la cual es opcional, la imagen de portada que también es opcional, el nombre de usuario, 
el correo, la contraseña la cual debe coincidir con el campo siguiente que es de verificación de la misma, y los usuarios de redes sociales como facebook, instagram y X.

Por el lado de iniciar sesión se tiene que ingresar el correo y la contraseña. Cada contraseña se ingresa encriptada por seguridad y adicionalmente esta sección contiene 
la opción de cambiar la contraseña en caso de olvidarla mediante un enlace que envia a otra página para ingresar el correo en el cual se enviará el enlace para cambiar la contraseña,
usa un método de verificación de usuario mediante tokens el cual tiene un tiempo limitado para cambiarla por seguridad.
Una vez que se recibe el correo mediante un enlace se puede acceder al cambio de contraseña la cual se debe ingresar dos veces, una vez cambiada, 
cumpliendo con los requisitos de la contraseña los cuales son mayusculas, minusculas , caracteres especiales y numeros, se confirma el cambio.

