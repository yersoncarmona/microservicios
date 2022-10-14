<?php

function getRealIP()
{
  if (isset($_SERVER["HTTP_CLIENT_IP"]))
  {
    return $_SERVER["HTTP_CLIENT_IP"];
    }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
        return $_SERVER["HTTP_X_FORWARDED"];
    }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }elseif (isset($_SERVER["HTTP_FORWARDED"])){
        return $_SERVER["HTTP_FORWARDED"];
    }else{
        return $_SERVER["REMOTE_ADDR"];
    }
}


function EntradaSegura($dato) {
  $dato = trim($dato);
  $dato = stripslashes($dato);
  $dato = htmlspecialchars($dato,ENT_QUOTES,"ISO-8859-1");
  $dato = strip_tags($dato);
  $dato = htmlentities($dato);
  return $dato;
}

/******************************************/
/******* Funciones de encriptación ********/
/******************************************/
function encripta($password) {
  return password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
}

function desencripta($password, $hash) {
  return password_verify($password, $hash);
}

function encrypt ($input,$Key="C0mf4n0rt32020") {
    $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($Key), $input, MCRYPT_MODE_CBC, md5(md5($Key))));
    return $output;
  }

function decrypt ($input,$Key="C0mf4n0rt32020") {
    $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5($Key))), "\0");
    return $output;
  }
/***************************************************/

?>
