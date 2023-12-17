<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function authUsuario($data){
  include("config.php");
  
  $email = $data->email;

  $executa = mysqli_query($con, "SELECT pk_usuario, email, senha FROM usuario
    WHERE email = '$email'");
  $saida = array();

  while($row = mysqli_fetch_array($executa)){
    array_push($saida, array("pk_usuario"=>intval($row['pk_usuario']),
                            "email"=>$row['email'],
                            "senha"=>$row['senha']));

  }
  if($saida){
    $saida = converteArrayParaUtf8($saida);
    echo json_encode($saida);
    exit;

  }else{
    array_push($saida, array("pk_usuario"=>null,
                            "email"=>null,
                            "senha"=>null));
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

authUsuario($data);

mysqli_close($con);
  
?>