<?php

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "El nom és obligatori ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "El mail és obligatori ";
} else {
    $email = $_POST["email"];
}

// TEL
$tel = $_POST["tel"];

// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "El missatge és obligatori ";
} else {
    $message = $_POST["message"];
}


$EmailTo = "ricardvilalta@hotmail.com,btiquets@btiquets.com";
$fromemail = "btiquets@btiquets.com";
$Subject = "BTiquets - Formulari de contacte de la web";

// prepare email body text
$Body = "";
$Body .= "Nom: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "Tel: ";
$Body .= $tel;
$Body .= "\n";
$Body .= "\n";
$Body .= "Missatge: ";
$Body .= $message;
$Body .= "\n";

// send email
$success = mail($EmailTo, $Subject, $Body, "From:".$fromemail);

// redirect to success page
if ($success && $errorMSG == ""){
   echo "success";
}else{
    if($errorMSG == ""){
        echo "Alguna cosa ha anat malament :(";
    } else {
        echo $errorMSG;
    }
}

?>