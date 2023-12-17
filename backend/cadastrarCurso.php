<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function cadastrarCurso($data){
  include("config.php");
  
  $nome = $data->nome;
  $totalHoras = $data->totalHoras;
  $valor = $data->valor;
  $descricao = $data->descricao;
  $tipoCurso = $data->tipoCurso;
  $localCurso = $data->localCurso;
  $dataCurso = $data->dataCurso;
  $horario = $data->horario;
  $linkMaterial = $data->linkMaterial;
  $email = $data->email;
  $fk_usuario = $data->pk_usuario;

  $saida = array();

  $executa = mysqli_query($con, "INSERT INTO curso (nome, total_horas, valor_curso, local_curso, data_curso, horario, descricao, tipo_curso, link_material, is_visivel, fk_usuario)
    VALUES ('$nome', '$totalHoras', '$valor', '$localCurso', '$dataCurso', '$horario', '$descricao', '$tipoCurso', '$linkMaterial', 1, '$fk_usuario')");
  array_push($saida, array("pk_curso"=>true));

  include'adicionaDeletaPontosMoedas.php';
  adicionaPontos($email, 30);
  
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
cadastrarCurso($data);

mysqli_close($con);
  
?>