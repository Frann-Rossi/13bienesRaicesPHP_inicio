<?php

define("TEMPLADES_URL", __DIR__ . "/templates");
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMAGENES", __DIR__  . "/../imagenes/");

function incluirTemplade(string $nombre, bool $inicio = false)
{
  include TEMPLADES_URL . "/$nombre.php";
}

function estaAutenticado()
{
  session_start();

  if (!$_SESSION["login"]) {
    return header("Location: /");
  }
}

function debugear($variable)
{
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
  exit;
}

//Escapa / Sanitizar el HTML

function s($html): string
{
  $s = htmlspecialchars($html);
  return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo)
{
  $tipos = ["vendedor", "propiedad"];

  return in_array($tipo, $tipos);
}

//Muestra los mensajes
function mostrarNotificacion($codigo)
{
  $mensaje = "";

  switch ($codigo) {
    case 1:
      $mensaje = "Creado Correctamente";
      break;
    case 2:
      $mensaje = "Actualizado Correctamente";
      break;
    case 3:
      $mensaje = "Eliminado Correctamente";
      break;
    default:
      $mensaje = false;
      break;
  }
  return $mensaje;
}