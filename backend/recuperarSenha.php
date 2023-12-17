<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function recuperarSenha($data){
  include("config.php");
  
  $email = $data->email;
  $novaSenha = $data->novaSenha;
  $hash = $data->hash;

  $executa = mysqli_query($con, "SELECT pk_usuario, email, senha FROM usuario
    WHERE email = '$email'");
  $saida = array();

  while($row = mysqli_fetch_array($executa)){
    array_push($saida, array("email"=>$row['email']));

  }
  if($saida){
    $executa = mysqli_query($con, "UPDATE usuario
    SET senha = '$hash'
    WHERE email = '$email'");
    $saida = array();
    
    include 'enviarEmail.php';
    if(enviarEmail($email, $novaSenha)){
        array_push($saida, array("email"=>true));
        $saida = converteArrayParaUtf8($saida);
        echo json_encode($saida);
        exit;
        
    }else{
        array_push($saida, array("email"=>false));
        $saida = converteArrayParaUtf8($saida);
        echo json_encode($saida);
        exit;

    }
  }else{
    array_push($saida, array("email"=>null));
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

recuperarSenha($data);

mysqli_close($con);
  
?>