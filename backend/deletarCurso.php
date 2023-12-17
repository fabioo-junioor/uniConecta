<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function deletarCurso($data){
  include("config.php");
  
  $pk_curso = $data->pk_curso;
  $pk_usuario = $data->pk_usuario;

  if(isset($_GET["deletarCurso"])){
    $executa = mysqli_query($con, "SELECT `avaliacao`.pk_avaliacao AS pk_avaliacao
      FROM curso, usuario, compravenda, avaliacao
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `curso`.pk_curso = '$pk_curso'
      AND `curso`.pk_curso = `compravenda`.fk_curso
      AND `compravenda`.fk_vendedor = '$pk_usuario'
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND ((`avaliacao`.stars_comprador IS NULL) OR (`avaliacao`.stars_vendedor IS NULL))");
    
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_avaliacao"=>intval($row['pk_avaliacao'])));
  
    }
    if($saida){
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }else{
      $executa = mysqli_query($con, "UPDATE curso 
      SET is_visivel = 0 WHERE pk_curso = '$pk_curso'");
      array_push($saida, array("pk_avaliacao"=>null));

      include'adicionaDeletaPontosMoedas.php';
      adicionaPontos(buscaEmail($pk_usuario), -30);   
  
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }
  }  
}

function buscaEmail($fk_usuario){
  include("config.php");
  
  $email = "";

  $executa = mysqli_query($con, "SELECT email FROM usuario WHERE pk_usuario = '$fk_usuario'");

  while($row = mysqli_fetch_array($executa)){
      $email = $row['email'];

  }
  return $email;

}
  
function converteArrayParaUtf8($saida){
    array_walk_recursive($saida, function(&$item,$key){
          if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);

            }
    });
    return $saida;

}

deletarCurso($data);

mysqli_close($con);
  
?>