<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function editarUsuario($data){
  include("config.php");
 
  $pk_usuario = $data->pk_usuario;
  $nome = $data->nome;
  $telefone = remove_caracteres($data->telefone);
  $graduacao = $data->graduacao;
  $img = $data->img;
  $senha = $data->senha;
  $permissaoTelefone = $data->permissaoTelefone;
  
  $executa = mysqli_query($con, "UPDATE usuario
    SET nome = '$nome', telefone = '$telefone', graduacao = '$graduacao', img = '$img', senha = '$senha', permissao_telefone = '$permissaoTelefone'
    WHERE pk_usuario = '$pk_usuario'");
    $saida = array();
    
    array_push($saida, array("pk_usuario"=>$pk_usuario));
    $saida = converteArrayParaUtf8($saida);
    echo json_encode($saida);
    exit;

}
  
function converteArrayParaUtf8($saida){
    array_walk_recursive($saida, function(&$item,$key){
          if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);

            }
    });
    return $saida;

}
function remove_caracteres($string){
  $result = str_replace(array("(",")","-"," "), '', $string);
  return trim($result, '');

}

editarUsuario($data);

mysqli_close($con);
  
?>