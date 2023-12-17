<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function buscarDadosCurso($data){
  include("config.php");

  $pk_curso = $data->pk_curso;
  
  if(isset($_GET["dadosEdicaoCurso"])){
    $executa = mysqli_query($con, "SELECT pk_curso, nome, total_horas, valor_curso, local_curso, data_curso, horario, descricao, tipo_curso, link_material
      FROM curso
      WHERE pk_curso = '$pk_curso'");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_curso"=>intval($row['pk_curso']),
                                "nome"=>$row['nome'],
                                "totalHoras"=>intval($row['total_horas']),
                                "valorCurso"=>intval($row['valor_curso']),
                                "localCurso"=>$row['local_curso'],
                                "dataCurso"=>$row['data_curso'],
                                "horario"=>$row['horario'],
                                "descricao"=>$row['descricao'],
                                "tipoCurso"=>$row['tipo_curso'],
                                "linkMaterial"=>$row['link_material']));
  
    }
    if($saida){
      $saida = converteArrayParaUtf8($saida);
      echo json_encode($saida);
      exit;
  
    }else{
      array_push($saida, array("pk_curso"=>null));
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

buscarDadosCurso($data);

mysqli_close($con);
  
?>