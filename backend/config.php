<?php 

$host = "localhost";
$user = "root"; 
$senha = ""; 
$dbname = "uniconecta";
$con = mysqli_connect($host, $user, $senha, $dbname);

// Verifica a conexão 
if (!$con) { 
   die("Falha na conexão: " . mysqli_connect_error());
   exit; 
}
?>