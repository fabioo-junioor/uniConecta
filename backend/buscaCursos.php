<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function buscarCursos($data){
  include("config.php");

  $pk_usuario = $data->pk_usuario;
  
  if(isset($_GET["buscaCursosVendidos"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `compravenda`.pk_compra_venda AS pk_compra_venda, `compravenda`.fk_comprador AS fk_comprador, `curso`.fk_usuario AS fk_usuarioCurso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `curso`.valor_curso AS cursoValor, `usuario`.nome AS usuarioNome
      FROM curso, usuario, compravenda, avaliacao
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `curso`.pk_curso = `compravenda`.fk_curso
      AND `compravenda`.fk_vendedor = '$pk_usuario'
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND `avaliacao`.stars_vendedor IS NULL");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("fk_usuarioCurso"=>intval($row['fk_usuarioCurso']),
                                "fk_comprador"=>intval($row['fk_comprador']),
                                "pk_compra_venda"=>intval($row['pk_compra_venda']),
                                "pk_curso"=>intval($row['pk_curso']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoValor"=>intval($row['cursoValor']),
                                "totalFavoritos"=>verificaTotalFavoritoCurso(intval($row['pk_curso'])),
                                "compradorNome"=>verificaCompradorCurso(intval($row['pk_compra_venda']))));
  
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
  if(isset($_GET["buscaCursosComprados"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `compravenda`.pk_compra_venda AS pk_compra_venda, `curso`.fk_usuario AS fk_usuarioCurso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `curso`.valor_curso AS cursoValor, `usuario`.nome AS usuarioNome
      FROM curso, usuario, compravenda, avaliacao
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `curso`.pk_curso = `compravenda`.fk_curso
      AND `compravenda`.fk_comprador = '$pk_usuario'
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND `avaliacao`.stars_comprador is null");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("fk_usuarioCurso"=>intval($row['fk_usuarioCurso']),
                                "pk_curso"=>intval($row['pk_curso']),
                                "pk_compra_venda"=>intval($row['pk_compra_venda']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoValor"=>intval($row['cursoValor']),
                                "favoritou"=>verificaCursoFavoritado(intval($row['pk_curso']), $pk_usuario),
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
  if(isset($_GET["buscaCursosAvaliados"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `compravenda`.pk_compra_venda AS pk_compra_venda, `compravenda`.fk_comprador AS fk_comprador, `curso`.fk_usuario AS fk_usuarioCurso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `curso`.valor_curso AS cursoValor, `usuario`.nome AS usuarioNome
      FROM curso, usuario, compravenda, avaliacao
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `curso`.pk_curso = `compravenda`.fk_curso
      AND `compravenda`.pk_compra_venda = `avaliacao`.fk_compra_venda
      AND (((`compravenda`.fk_comprador = '$pk_usuario') AND (`avaliacao`.stars_comprador IS NOT NULL))OR((`compravenda`.fk_vendedor = '$pk_usuario') AND (`avaliacao`.stars_vendedor IS NOT NULL)))");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("fk_usuarioCurso"=>intval($row['fk_usuarioCurso']),
                                "pk_curso"=>intval($row['pk_curso']),
                                "fk_comprador"=>intval($row['fk_comprador']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoValor"=>intval($row['cursoValor']),
                                "favoritou"=>verificaCursoFavoritado(intval($row['pk_curso']), $pk_usuario),
                                "totalFavoritos"=>verificaTotalFavoritoCurso(intval($row['pk_curso'])),
                                "compradorNome"=>verificaCompradorCurso(intval($row['pk_compra_venda']))));
  
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
  if(isset($_GET["buscaTodosCursos"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `curso`.fk_usuario AS fk_usuarioCurso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `curso`.valor_curso AS cursoValor, `usuario`.nome AS usuarioNome
      FROM curso, usuario
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `curso`.is_visivel = 1");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_curso"=>intval($row['pk_curso']),
                                "fk_usuarioCurso"=>intval($row['fk_usuarioCurso']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoValor"=>intval($row['cursoValor']),
                                "favoritou"=>verificaCursoFavoritado(intval($row['pk_curso']), $pk_usuario),
                                "totalFavoritos"=>verificaTotalFavoritoCurso(intval($row['pk_curso'])),
                                "cursoComprado"=>verificaCompraCurso(intval($row['pk_curso']), $pk_usuario)));
  
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
  if(isset($_GET["buscaMeusCursos"])){
    $executa = mysqli_query($con, "SELECT `curso`.pk_curso AS pk_curso, `curso`.nome AS cursoNome, `curso`.tipo_curso AS tipoCurso, `usuario`.nome AS usuarioNome, `curso`.valor_curso AS cursoValor, `curso`.is_visivel AS isVisivel
      FROM curso, usuario
      WHERE `curso`.fk_usuario = `usuario`.pk_usuario
      AND `usuario`.pk_usuario = '$pk_usuario'
      GROUP BY `curso`.pk_curso");
    $saida = array();
  
    while($row = mysqli_fetch_array($executa)){
      array_push($saida, array("pk_curso"=>intval($row['pk_curso']),
                                "cursoNome"=>$row['cursoNome'],
                                "tipoCurso"=>$row['tipoCurso'],
                                "usuarioNome"=>$row['usuarioNome'],
                                "cursoValor"=>intval($row['cursoValor']),
                                "isVisivel"=>intval($row['isVisivel']),
                                "favoritou"=>verificaCursoFavoritado(intval($row['pk_curso']), $pk_usuario),
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

buscarCursos($data);

mysqli_close($con);
  
?>