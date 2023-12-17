<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function editarCurso($data){
  include("config.php");
 
  
  $pk_curso = $data->pk_curso;
  $nome = $data->nome;
  $tipoCurso = $data->tipoCurso;
  $totalHoras = $data->totalHoras;
  $valorCurso = $data->valorCurso;
  $localCurso = $data->localCurso;
  $dataCurso = $data->dataCurso;
  $horario = $data->horario;
  $descricao = $data->descricao;
  $linkMaterial = $data->linkMaterial;
  
  
  $executa = mysqli_query($con, "UPDATE curso
    SET nome = '$nome', total_horas = '$totalHoras', valor_curso = '$valorCurso', local_curso = '$localCurso', data_curso = '$dataCurso', horario = '$horario', descricao = '$descricao', link_material = '$linkMaterial'
    WHERE pk_curso = '$pk_curso'");
    $saida = array();
    
    array_push($saida, array("pk_curso"=>$pk_curso));
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

editarCurso($data);

mysqli_close($con);
  
?>