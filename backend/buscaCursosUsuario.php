<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function buscarCursosUsuario($data){
  include("config.php");

  $pk_usuarioLogado = $data->pk_usuarioLogado;
  $pk_usuarioPerfil = $data->pk_usuarioPerfil;
  
  if(isset($_GET["buscaCursosUsuario"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `usuario`.nome AS usuarioNome, `curso`.valor_curso AS cursoValor, `curso`.total_horas AS totalHoras, `curso`.valor_curso AS valorCurso
      FROM curso, usuario
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `usuario`.pk_usuario = '$pk_usuarioPerfil'
      AND `curso`.is_visivel = 1
      GROUP BY `curso`.pk_curso");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_curso"=>intval($row['pk_curso']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoValor"=>intval($row['cursoValor']),
                                "totalHoras"=>intval($row['totalHoras']),
                                "valorCurso"=>intval($row['valorCurso']),
                                "cursoComprado"=>verificaCompraCurso(intval($row['pk_curso']), $pk_usuarioLogado),
                                "favoritou"=>verificaCursoFavoritado(intval($row['pk_curso']), $pk_usuarioLogado),
                                "totalFavoritos"=>verificaTotalFavoritoCurso(intval($row['pk_curso']))));
  
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

function verificaTotalFavoritoCurso($pk_curso){
  include("config.php");
  $total = null;

  $executa = mysqli_query($con, "SELECT COUNT(pk_favorito) AS total
      FROM favorito
      WHERE fk_curso = '$pk_curso'");
  
    while($row = mysqli_fetch_array($executa)){
      $total = intval($row['total']);
  
    }

    return $total === null ? 0 : $total;

}

function verificaCursoFavoritado($pk_curso, $pk_usuario){
  include("config.php");
  $favoritou = null;

  $executa = mysqli_query($con, "SELECT fk_usuario
      FROM favorito
      WHERE fk_curso = '$pk_curso'
      AND fk_usuario = '$pk_usuario'");
  
    while($row = mysqli_fetch_array($executa)){
      $favoritou = intval($row['fk_usuario']);
  
    }

    return $favoritou === null ? 0 : $favoritou;

}
function verificaCompraCurso($pk_curso, $pk_usuario){
  include("config.php");
  $comprado = null;

  $executa = mysqli_query($con, "SELECT fk_comprador
      FROM compravenda
      WHERE fk_curso = '$pk_curso'
      AND fk_comprador = '$pk_usuario'");
  
    while($row = mysqli_fetch_array($executa)){
      $comprado = intval($row['fk_comprador']);
  
    }

    return $comprado === null ? 0 : $comprado;

}
function verificaCompradorCurso($pk_compra_venda){
  include("config.php");
  $comprador = "";

  $executa = mysqli_query($con, "SELECT `usuario`.nome AS nomeComprador
      FROM compravenda, usuario
      WHERE pk_compra_venda = '$pk_compra_venda'
      AND `compravenda`.fk_comprador = `usuario`.pk_usuario");
  
    while($row = mysqli_fetch_array($executa)){
      $comprador = $row['nomeComprador'];
  
    }

    return $comprador === "" ? "" : $comprador;

}

buscarCursosUsuario($data);

mysqli_close($con);
  
?>