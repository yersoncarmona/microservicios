<?php
require_once("util/conexionBD.php");
include "util/funciones.php";

//valida metodo POST
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  if(!isset($data['nombre'])||!isset($data['perfil'])||!isset($data['email'])||!isset($data['clave'])){
    $respuesta=array(
      'Mensaje'=> 'DATOS INVALIDOS'
    );
    echo json_encode($respuesta,http_response_code(200));
    return;
  }
  $nombre=strtoupper($data['nombre']);
  $perfil=strtoupper($data['perfil']);
  $email=strtoupper($data['email']);
  $clave=md5($data['clave']);

  $consulta="SELECT id
                    FROM usuario
                      WHERE correo='$email'";

  if (!$resultado = $con->query($consulta)) {
    $respuesta=array(
      'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
    );
    echo json_encode($respuesta,http_response_code(500));
    return;
  }
  else{

    if ($resultado->num_rows === 0) {
      $partes = explode("@", $email);
      if(!isset($partes[1])){
        $respuesta=array(
          'Mensaje'=> 'FORMATO DE CORREO INVALIDO'
        );
        echo json_encode($respuesta,http_response_code(200));
        return;
      }
      if($partes[1]<>"UFPS.EDU.CO"){
        $respuesta=array(
          'Mensaje'=> 'CORREO NO PERMITIDO PARA NUEVO USUARIO'
        );
        echo json_encode($respuesta,http_response_code(200));
        return;
      }
      $insert="INSERT INTO usuario(nombre, correo, clave, perfil)
                VALUES ('$nombre','$email','$clave','$perfil')";
      if (!$resultado = $con->query($insert)) {
          $respuesta=array(
            'Mensaje'=> 'ERROR INTERNO, INTENTE MAS TARDE'
          );
          echo json_encode($respuesta,http_response_code(500));
          return;
      }
      else{
        $respuesta=array(
          'Mensaje'=> 'USUARIO CREADO CORRECTAMENTE'
        );
        echo json_encode($respuesta,http_response_code(200));
        return;
      }
    }
    else{
      $respuesta=array(
        'Mensaje'=> 'CORREO YA ESTA EN USO'
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
