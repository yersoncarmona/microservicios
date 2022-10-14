<?php
require_once("util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='GET'){
  $data = json_decode(file_get_contents('php://input'), true);
  if(!isset($data['email'])||!isset($data['clave'])){
    $respuesta=array(
      'Mensaje'=> 'DATOS INVALIDOS'
    );
    echo json_encode($respuesta,http_response_code(200));
    return;
  }
  $email=$data['email'];
  $clave=md5($data['clave']);

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
      $usuario = $resultado->fetch_assoc();
      $respuesta=array(
        'usuario_id'=> $usuario['id'],
        'nombre'=> $usuario['nombre'],
        'perfil'=> $usuario['perfil'],
      );
      echo json_encode($respuesta,http_response_code(200));
      return;
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
