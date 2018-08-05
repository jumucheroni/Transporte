<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "transporte";

//$conexao = @mysqli_connect($database, $user, $pass, );
$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Conexão falhou com banco de dados: " . $conn->connect_error);
} 


function DtToDb($arg) {

    $dbresult = "";

    if ($arg != "") {

        $auxano1 = substr($arg, 6, 4);

        $auxmes1 = substr($arg, 3, 2);

        $auxdia1 = substr($arg, 0, 2);

        $dbresult = $auxano1 . "-" . $auxmes1 . "-" . $auxdia1;

        return $dbresult;
    }

    return $dbresult;
}

function DbToDt($arg) {

    $dtresult = "";

    if ($arg != "") {

        $auxano1 = substr($arg, 0, 4);

        $auxmes1 = substr($arg, 5, 2);

        $auxdia1 = substr($arg, 8, 2);

        $dtresult = $auxdia1 . "/" . $auxmes1 . "/" . $auxano1;

        return $dtresult;
    }

    return $dtresult;
}
?>