<?php
require "../../includes/app.php";

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

$propiedad = new Propiedad;

// Consulta para obtener todos los vendedores
$vendedores = Vendedor::all();

// Arreglo con mensaje de errores
$errores = Propiedad::getErrores();

//Ejecutando el código depués de que el usario envia el formulario 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Crea una NUEVA instancia
  $propiedad = new Propiedad($_POST["propiedad"]);

  //**  Subida de Archivos **//

  //Generar un nombre unico
  $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

  // Setear la imagen
  //Realiza un resize a la imagen con intevention 
  if ($_FILES["propiedad"]["tmp_name"]["imagen"]) {
    $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800, 600);
    $propiedad->setImagen($nombreImagen);
  }

  // Validar
  $errores = $propiedad->validar();


  if (empty($errores)) {
    // Crear la carpeta para subir imagenes
    if (!is_dir(CARPETA_IMAGENES)) {
      mkdir(CARPETA_IMAGENES);
    }

    // Guarda la imagen en el servidor
    $image->save(CARPETA_IMAGENES . $nombreImagen);

    // Guarda en la BD
    $propiedad->guardar();
  }
}

incluirTemplade("header");
?>


<main class="contenedor seccion">
  <h1>Crear</h1>


  <a href="/admin" class="boton boton-verde">Volver</a>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach; ?>

  <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
    <?php include "../../includes/templates/formulario_propiedades.php"; ?>
    <input type="submit" value="Crear Propiedad" class="boton boton-verde">
  </form>

</main>

<?php
incluirTemplade("footer");
?>