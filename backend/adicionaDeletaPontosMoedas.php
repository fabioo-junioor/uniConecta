<?php

function adicionaMoedas($email, $quantidade){
  include("config.php");
  $novoTotal = null;

  $executa = mysqli_query($con, "SELECT total_moedas FROM moedas
    WHERE fk_usuario = (SELECT pk_usuario from usuario WHERE email='$email')");

  while($row = mysqli_fetch_array($executa)){
    $novoTotal = intval($row['total_moedas']) + $quantidade;

  }

  $executa2 = mysqli_query($con, "UPDATE moedas
    SET total_moedas = '$novoTotal'
    WHERE fk_usuario = (SELECT pk_usuario from usuario WHERE email='$email')");

    return true;

}
function adicionaPontos($email, $quantidade){
  include("config.php");
  $novoTotal = null;

  $executa = mysqli_query($con, "SELECT total_pontos FROM pontos
    WHERE fk_usuario = (SELECT pk_usuario from usuario WHERE email='$email')");

  while($row = mysqli_fetch_array($executa)){
    $novoTotal = intval($row['total_pontos']) + $quantidade;

  }

  $executa2 = mysqli_query($con, "UPDATE pontos
    SET total_pontos = '$novoTotal'
    WHERE fk_usuario = (SELECT pk_usuario from usuario WHERE email='$email')");

    return true;

}

mysqli_close($con);
  
?>