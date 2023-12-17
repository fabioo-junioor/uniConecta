<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($destinatario, $novaSenha){

    $email = new PHPMailer();
    
    $email->isSMTP();
    $email->Host = "smtp.gmail.com";
    $email->SMTPAuth = "true";
    $email->SMTPSecure = "tls";
    $email->Port = "587";
    $email->Username = "fcjunior@inf.ufsm.br";
    $email->Password = "131313si%";
    $email->Subject = "<UniConecta> Recuparaçao de senha";
    $email->setFrom("fcjunior@inf.ufsm.br");
    $email->Body = 'Faca o login com a nova senha a seguir: '.$novaSenha;
    $email->addAddress($destinatario);
    
    
    if($email->Send()){
        return true;        
    
    }else{
        return false;        
        
    }
    $email->smtpClose();
}

?>