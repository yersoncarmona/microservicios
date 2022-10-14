<?php
require_once("util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  if(!isset($data['email'])||!isset($data['clave'])||!isset($data['nombre'])){
    $respuesta=array(
      'Mensaje'=> 'DATOS INVALIDOS'
    );
    echo json_encode($respuesta,http_response_code(200));
    return;
  }
  $clave=md5($data['clave']);
  $email=strtoupper($data['email']);
  $nombre=strtoupper($data['nombre']);

  $consulta="SELECT nombre, perfil,correo, id
                    FROM usuario
                      WHERE correo='$email' AND clave='$clave' AND estado='ACTIVO'";

  if (!$resultado = $con->query($consulta)) {
    $respuesta=array(
      'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
    );
    echo json_encode($respuesta,http_response_code(500));
    return;
  }
  else{
    if ($resultado->num_rows === 0) {
      $respuesta=array(
        'Mensaje'=> 'USUARIO INACTIVO O CORREO/CLAVE INCORRECTA'
      );
      echo json_encode($respuesta,http_response_code(200));
      return;
    }
    else{
      $update="UPDATE usuario set nombre='$nombre'
                WHERE correo='$email' AND clave='$clave'";
      if (!$resultado = $con->query($update)) {
          $respuesta=array(
            'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
          );
          echo json_encode($respuesta,http_response_code(500));
          return;
      }
      else{
        $respuesta=array(
          'Mensaje'=> 'USUARIO EDITADO CORRECTAMENTE'
        );
        echo json_encode($respuesta,http_response_code(200));
        return;
      }

    }
  }

}

else{
  $respuesta=array(
    'Error'=> 'METODO NO VALIDO'
  );
  echo json_encode($respuesta,http_response_code(400));
  return;
}

 ?>
