<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function adicionaDeletaFavorito($data){
  include("config.php");

  $fk_curso = $data->fk_curso;
  $fk_usuario = $data->fk_usuario;
  $email = $data->email;
  
  if(isset($_GET["adicionaFavorito"])){
    $executa = mysqli_query($con, "SELECT * FROM favorito
    WHERE fk_curso = '$fk_curso' AND fk_usuario = '$fk_usuario'");
    $saida = array();

    while($row = mysqli_fetch_array($executa)){
        array_push($saida, array("pk_favorio"=>intval($row['pk_favorito'])));

    }
    if($saida){
        $saida = converteArrayParaUtf8($saida);
        echo json_encode($saida);
        exit;

    }else{
        $executa = mysqli_query($con, "INSERT INTO favorito (fk_curso, fk_usuario)
        VALUES ('$fk_curso', '$fk_usuario')");
        array_push($saida, array("pk_favorito"=>null));

        include'adicionaDeletaPontosMoedas.php';
        adicionaPontos($email, 10);

        $saida = converteArrayParaUtf8($saida);
        echo json_encode($saida);
        exit;

    } 
    
  }
  if(isset($_GET["deletaFavorito"])){
    $executa = mysqli_query($con, "SELECT * FROM favorito
    WHERE fk_curso = '$fk_curso' AND fk_usuario = '$fk_usuario'");
    $saida = array();

    while($row = mysqli_fetch_array($executa)){
        array_push($saida, array("pk_favorio"=>intval($row['pk_favorito'])));

    }
    if($saida){
        $executa = mysqli_query($con, "DELETE FROM favorito
           WHERE fk_curso = '$fk_curso' AND fk_usuario = '$fk_usuario'");
        array_push($saida, array("pk_favorito"=>null));

        include'adicionaDeletaPontosMoedas.php';
        adicionaPontos($email, -10);

        $saida = converteArrayParaUtf8($saida);
        echo json_encode($saida);
        exit;

    }else{        
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

adicionaDeletaFavorito($data);

mysqli_close($con);
  
?>