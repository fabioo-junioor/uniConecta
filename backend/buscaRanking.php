<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function buscarRanking($data){
  include("config.php");  
  
  if(isset($_GET["maioresPontuacoes"])){
    $executa = mysqli_query($con, "SELECT pk_usuario, nome, total_pontos
      FROM usuario, pontos
      WHERE pk_usuario = `pontos`.fk_usuario
      ORDER BY total_pontos DESC");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_usuario"=>intval($row['pk_usuario']),
                                "nomeUsuario"=>$row['nome'],
                                "totalPontos"=>intval($row['total_pontos'])));
  
    }
    if($saida){
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }else{
      array_push($saida, array("pk_usuario"=>null));
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }
  }
  if(isset($_GET["maisComprados"])){
    $executa = mysqli_query($con, "SELECT pk_usuario, `curso`.nome AS nome_curso, `usuario`.nome AS nome_usuario, COUNT(`curso`.nome) AS total_compras
      FROM usuario, curso, compravenda, avaliacao
      WHERE `usuario`.pk_usuario = `curso`.fk_usuario
      AND `curso`.pk_curso = `compravenda`.fk_curso
      AND `usuario`.pk_usuario = `compravenda`.fk_vendedor
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND ((`avaliacao`.stars_vendedor > 0) AND (`avaliacao`.stars_comprador > 0))
      GROUP BY nome_curso");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_usuario"=>intval($row['pk_usuario']),
                                "nomeUsuario"=>$row['nome_usuario'],
                                "nomeCurso"=>$row['nome_curso'],
                                "totalCompras"=>intval($row['total_compras'])));
  
    }
    if($saida){
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }else{
      array_push($saida, array("pk_usuario"=>null));
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }
   
    
  }
}
  
function converteArrayParaUtf8($saida){
    array_walk_recursive($saida, function(&$item,$key){
          if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);

            }
    });
    return $saida;

}

buscarRanking($data);

mysqli_close($con);
  
?>