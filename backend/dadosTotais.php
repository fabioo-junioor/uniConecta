<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function dadosTotais($data){
  include("config.php");  
  
  if(isset($_GET["totalUsuarios"])){
    $executa = mysqli_query($con, "SELECT COUNT(pk_usuario) AS totalUsuario
      FROM usuario");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("totalUsuario"=>intval($row['totalUsuario'])));
  
    }

    $saida = converteArrayParaUtf8($saida);
    echo json_encode($saida);
    exit;
  
  }
  if(isset($_GET["totalCursos"])){
    $executa = mysqli_query($con, "SELECT COUNT(pk_curso) AS totalCurso
      FROM curso WHERE is_visivel = 1");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("totalCurso"=>intval($row['totalCurso'])));
  
    }
    
    $saida = converteArrayParaUtf8($saida);
    echo json_encode($saida);
    exit;  
    
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

dadosTotais($data);

mysqli_close($con);
  
?>