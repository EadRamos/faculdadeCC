<?php
require_once 'db_connect.php';
session_start();

// inserindo
$sql = "insert into usuario (nome,login,senha,foto,administrador) value ('aluno1','cc.aluno1','12345678','https:imagem', 0)";
if($connect->query($sql) === true){
    echo "Inserido com sucesso";
    echo "<br>";
}
else{
    echo "ouve um erro";
    echo "<br>";
}
// consultando
$sql = "select * from usuario";
$resultado = $connect->query($sql);
if($resultado->num_rows == 0){
    echo "Não há nada";
    echo "<br>";
}else{
    while($linha = $resultado->fetch_object()){
        echo "Nome: ".$linha->nome."";
        echo "<br>";
    }
}