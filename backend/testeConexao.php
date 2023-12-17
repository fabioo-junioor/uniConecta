<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function testeConexao($data){
  include("config.php");  
  
  if(isset($_GET["testeConexao"])){
    $saida = array();

    if($con){
        array_push($saida, array("connection"=>true));
        $saida = converteArrayParaUtf8($saida);
        echo json_encode($saida);
        exit;
  
    }else{
      array_push($saida, array("connection"=>false));
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

testeConexao($data);

mysqli_close($con);
  
?>