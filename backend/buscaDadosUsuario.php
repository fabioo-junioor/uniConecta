<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function buscarUsuario($data){
  include("config.php");

  $pk_usuario = $data->pk_usuario;
  
  if(isset($_GET["dadosPreview"])){
    $executa = mysqli_query($con, "SELECT pk_usuario, nome, telefone, email, graduacao, img, total_pontos, total_moedas, permissao_telefone
      FROM usuario, pontos, moedas
      WHERE pk_usuario = '$pk_usuario'
      AND pk_usuario = `pontos`.fk_usuario
      AND pk_usuario = `moedas`.fk_usuario");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_usuario"=>intval($row['pk_usuario']),
                                "nome"=>$row['nome'],
                                "telefone"=>$row['telefone'],
                                "graduacao"=>$row['graduacao'],
                                "email"=>$row['email'],
                                "img"=>$row['img'],
                                "total_pontos"=>intval($row['total_pontos']),
                                "total_moedas"=>intval($row['total_moedas']),
                                "permissaoTelefone"=>intval($row['permissao_telefone']),
                                "mediaStars"=>buscaMediaStars(intval($row['pk_usuario']))));
  
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
  if(isset($_GET["dadosEdicao"])){
    $executa = mysqli_query($con, "SELECT pk_usuario, nome, email, telefone, graduacao, img, permissao_telefone
      FROM usuario
      WHERE pk_usuario = '$pk_usuario'");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_usuario"=>intval($row['pk_usuario']),
                                "nome"=>$row['nome'],
                                "email"=>$row['email'],
                                "telefone"=>$row['telefone'],
                                "graduacao"=>$row['graduacao'],
                                "img"=>$row['img'],
                                "permissaoTelefone"=>intval($row['permissao_telefone'])));
  
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
function buscaMediaStars($pk_usuario){
  include("config.php");
  $somaMediaC = null;
  $qtdAvaliacaoC = null;
  $somaMediaV = null;
  $qtdAvaliacaoV = null;
  $mediaStars = null;

  $executa = mysqli_query($con, "SELECT SUM(`avaliacao`.stars_comprador) AS somaMediaC, COUNT(`avaliacao`.pk_avaliacao) AS qtdAvaliacaoC
      FROM usuario, compravenda, avaliacao
      WHERE `usuario`.pk_usuario = `compravenda`.fk_comprador
      AND `usuario`.pk_usuario = '$pk_usuario'
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND `avaliacao`.stars_comprador IS NOT NULL");
  
    while($row = mysqli_fetch_array($executa)){
      $somaMediaC = $row['somaMediaC'];
      $qtdAvaliacaoC = $row['qtdAvaliacaoC'];
  
    }

  $executa2 = mysqli_query($con, "SELECT SUM(`avaliacao`.stars_vendedor) AS somaMediaV, COUNT(`avaliacao`.pk_avaliacao) AS qtdAvaliacaoV
      FROM usuario, compravenda, avaliacao
      WHERE `usuario`.pk_usuario = `compravenda`.fk_vendedor
      AND `usuario`.pk_usuario = '$pk_usuario'
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND `avaliacao`.stars_vendedor IS NOT NULL");
  
    while($row2 = mysqli_fetch_array($executa2)){
      $somaMediaV = $row2['somaMediaV'];
      $qtdAvaliacaoV = $row2['qtdAvaliacaoV'];
  
    }
    if(($qtdAvaliacaoC > 0)||($qtdAvaliacaoV > 0)){
      $mediaStars = (($somaMediaC + $somaMediaV)/($qtdAvaliacaoC + $qtdAvaliacaoV));
      return $mediaStars;

    }else{
      return 0;

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

buscarUsuario($data);

mysqli_close($con);
  
?>