<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function buscaInfoCurso($data){
  include("config.php");

  $pk_curso = $data->pk_curso;
  
  if(isset($_GET["buscaInfoCurso"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `usuario`.nome AS usuarioNome, `curso`.descricao AS cursoDescricao, `curso`.total_horas AS totalHoras, `curso`.valor_curso AS valorCurso, `curso`.link_material AS linkMaterial, `curso`.data_curso AS dataCurso, `curso`.local_curso AS localCurso, `curso`.horario AS horario 
      FROM curso, usuario
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `curso`.pk_curso = '$pk_curso'");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_curso"=>intval($row['pk_curso']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoDescricao"=>$row['cursoDescricao'],
                                "linkMaterial"=>$row['linkMaterial'],
                                "localCurso"=>$row['localCurso'],
                                "dataCurso"=>$row['dataCurso'],
                                "horario"=>$row['horario'],
                                "totalHoras"=>intval($row['totalHoras']),
                                "valorCurso"=>intval($row['valorCurso'])));
  
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

buscaInfoCurso($data);

mysqli_close($con);
  
?>