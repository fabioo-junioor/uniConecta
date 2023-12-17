<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

function compraCurso($data){
    include("config.php");

    $fk_comprador = $data->fk_comprador;
    $fk_vendedor = $data->fk_vendedor;
    $fk_curso = $data->fk_curso;

    if(isset($_GET["compraCurso"])){
        $saida = array();

        if(buscaTotalMoedas($fk_comprador) >= buscaValorCurso($fk_curso)){
            $executa = mysqli_query($con, "INSERT INTO compravenda (data_hora, fk_comprador, fk_vendedor, fk_curso)
            VALUES (now(), '$fk_comprador', '$fk_vendedor', '$fk_curso')");
        
            array_push($saida, array("pk_compra_venda"=>criaRegistroAvaliacao()));
            
            include'adicionaDeletaPontosMoedas.php';
            adicionaPontos(buscaEmail($fk_comprador), 30);
            adicionaPontos(buscaEmail($fk_vendedor), 50);

            adicionaMoedas(buscaEmail($fk_vendedor), buscaValorCurso($fk_curso));
            adicionaMoedas(buscaEmail($fk_comprador), -buscaValorCurso($fk_curso));

            $saida = converteArrayParaUtf8($saida);
            echo json_encode($saida);
            exit;

        }else{
            array_push($saida, array("pk_compra_venda"=>null));
            
            $saida = converteArrayParaUtf8($saida);
            echo json_encode($saida);
            exit;

        }
    }
}

function buscaValorCurso($fk_curso){
    include("config.php");
    
    $valorCurso = null;
  
    $executa = mysqli_query($con, "SELECT valor_curso FROM curso WHERE pk_curso = '$fk_curso'");

    while($row = mysqli_fetch_array($executa)){
        $valorCurso = intval($row['valor_curso']);

    }
    return $valorCurso;

}

function buscaTotalMoedas($fk_usuario){
    include("config.php");
    
    $totalMoedas = null;
  
    $executa = mysqli_query($con, "SELECT total_moedas FROM moedas WHERE fk_usuario = '$fk_usuario'");

    while($row = mysqli_fetch_array($executa)){
        $totalMoedas = intval($row['total_moedas']);

    }
    return $totalMoedas;

}

function buscaEmail($fk_usuario){
    include("config.php");
    
    $email = "";
  
    $executa = mysqli_query($con, "SELECT email FROM usuario WHERE pk_usuario = '$fk_usuario'");

    while($row = mysqli_fetch_array($executa)){
        $email = $row['email'];

    }
    return $email;

}

function criaRegistroAvaliacao(){
    include("config.php");
    
    $pk_compra_venda = null;
  
    $executa = mysqli_query($con, "SELECT MAX(pk_compra_venda) AS pk_compra_venda FROM compravenda");

    while($row = mysqli_fetch_array($executa)){
        $pk_compra_venda = intval($row['pk_compra_venda']);

    }
    $executa = mysqli_query($con, "INSERT INTO avaliacao (fk_compra_venda)
        VALUES ('$pk_compra_venda')");
    
    return $pk_compra_venda === null ? 0 : $pk_compra_venda;

}

function converteArrayParaUtf8($saida){
    array_walk_recursive($saida, function(&$item,$key){
          if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);

            }
    });
    return $saida;

}

compraCurso($data);

mysqli_close($con);

?>