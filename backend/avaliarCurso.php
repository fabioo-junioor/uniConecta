<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function avaliarCurso($data){
  include("config.php");
  
  $pk_compra_venda = $data->pk_compra_venda;
  $notaAvaliacao = $data->notaAvaliacao;

  if(isset($_GET["avaliarCursoComprado"])){
    $executa = mysqli_query($con, "UPDATE avaliacao
      SET stars_comprador = '$notaAvaliacao'
      WHERE fk_compra_venda = '$pk_compra_venda'");
      $saida = array();

      array_push($saida, array("pk_compra_venda"=>$pk_compra_venda));
      
      include'adicionaDeletaPontosMoedas.php';
      adicionaPontos(buscaEmailVendedor($pk_compra_venda), $notaAvaliacao*10);
      adicionaMoedas(buscaEmailComprador($pk_compra_venda), 10);
      
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
  }
  if(isset($_GET["avaliarCursoVendido"])){
    $executa = mysqli_query($con, "UPDATE avaliacao
      SET stars_vendedor = '$notaAvaliacao'
      WHERE fk_compra_venda = '$pk_compra_venda'");
      $saida = array();
      
      array_push($saida, array("pk_compra_venda"=>$pk_compra_venda));
      
      include'adicionaDeletaPontosMoedas.php';
      adicionaPontos(buscaEmailVendedor($pk_compra_venda), $notaAvaliacao*10);
      adicionaMoedas(buscaEmailComprador($pk_compra_venda), 10);
      
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
  }
}

function buscaEmailVendedor($pk_compra_venda){
  include("config.php");
  
  $email = "";

  $executa = mysqli_query($con, "SELECT email 
    FROM compravenda, usuario 
    WHERE `compravenda`.pk_compra_venda = '$pk_compra_venda'
    AND `compravenda`.fk_vendedor = `usuario`.pk_usuario");

  while($row = mysqli_fetch_array($executa)){
      $email = $row['email'];

  }
  return $email;

}

function buscaEmailComprador($pk_compra_venda){
  include("config.php");
  
  $email = "";

  $executa = mysqli_query($con, "SELECT email 
    FROM compravenda, usuario 
    WHERE `compravenda`.pk_compra_venda = '$pk_compra_venda'
    AND `compravenda`.fk_comprador = `usuario`.pk_usuario");

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

avaliarCurso($data);

mysqli_close($con);
  
?>