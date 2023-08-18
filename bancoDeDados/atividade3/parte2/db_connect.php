<?php
$nomeservidor = "projetologico.czwycxaaaorc.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "12345678";
$dbname = "dbvacina";

$connect = mysqli_connect($nomeservidor,$username,$password,$dbname);

if(mysqli_connect_error()){
    echo "Erro na conexão: ".mysqli_connect_error();
}else{
    echo "Conectado";
}

//$connect->close();