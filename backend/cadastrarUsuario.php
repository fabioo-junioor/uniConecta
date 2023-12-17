<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function cadastrarUsuario($data){
  include("config.php");
  
  $nome = $data->nome;
  $email = $data->email;
  $telefone = remove_caracteres($data->telefone);
  $senha = $data->senha;
  $permissaoTelefone = intval($data->permissaoTelefone);

  $executa = mysqli_query($con, "SELECT * FROM usuario
    WHERE email = '$email'");
  $saida = array();

  while($row = mysqli_fetch_array($executa)){
    array_push($saida, array("pk_usuario"=>intval($row['pk_usuario'])));

  }
  if($saida){
    $saida = converteArrayParaUtf8($saida);
    echo json_encode($saida);
    exit;

  }else{
    $executa = mysqli_query($con, "INSERT INTO usuario (nome, email, telefone, senha, permissao_telefone)
      VALUES ('$nome', '$email', '$telefone', '$senha', '$permissaoTelefone')");
    array_push($saida, array("pk_usuario"=>null));
    
    criaRegistroMoedas($email);
    criaRegistroPontos($email);

    include'adicionaDeletaPontosMoedas.php';
    adicionaMoedas($email, 20);
    adicionaPontos($email, 30);

    $saida = converteArrayParaUtf8($saida);
    echo json_encode($saida);
    exit;

  }  
}
function criaRegistroMoedas($email){
  include("config.php");
  $executa = mysqli_query($con, "INSERT INTO moedas (total_moedas, fk_usuario)
      VALUES (0, (SELECT pk_usuario from usuario WHERE email='$email'))");

      return true;

}
function criaRegistroPontos($email){
  include("config.php");
  $executa = mysqli_query($con, "INSERT INTO pontos (total_pontos, fk_usuario)
      VALUES (0, (SELECT pk_usuario from usuario WHERE email='$email'))");

      return true;

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
  return trim($result, ' ');

}

cadastrarUsuario($data);

mysqli_close($con);
  
?>