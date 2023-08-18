<?php
require_once "db_connect.php";
session_start();
$erro = null;
$comorbidades = [];
if(isset($_POST["btn-vacina"])){
    $nomeVacina = $_POST["nome-vacina"];
    $sqlp = "SELECT c.nome
    FROM comorbidades_vacina cv
    JOIN vacina v ON cv.vacina_id = v.nome_vacina
    JOIN comorbidades c ON cv.comorbidade_id = c.nome
    WHERE v.nome_vacina = '$nomeVacina';";
    $resultado = mysqli_query($connect,$sqlp);
    if(mysqli_num_rows($resultado) > 0){
        while($linha = mysqli_fetch_object($resultado)){
            $comorbidades[] = $linha;
        }
    }
    else{
        $erro = "a vacina passada não tem comorbidades!";
    }
}
$resul = null;
if(isset($_POST["btn-adicionar"])){
    $nomeAdd = $_POST['nome-add'];
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
    $sqladd = "INSERT INTO vacina (nome_vacina,quantidade) VALUES ('$nomeAdd','$quantidade');";
    if(mysqli_query($connect,$sqladd)){
       $resul = "adicionado com sucesso!";
    }
    else{
        $resul = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio</title>
</head>
<body>

    <h2>Pagina inicial</h2>
    <h3>Pesquisa comorbidades de uma vacina:</h3>
    <form action="" method="post">
        Nome vacina: <input type="text" name="nome-vacina">
        <button type="submit" name="btn-vacina">Pesquisar</button>
    </form>
    <br>
    <?php
    if($comorbidades != null){
        echo require_once "tabelaPesquisa.php";
    }elseif($erro != null){
        echo $erro;
    }
    ?>

    <br>
    <h3>Adicione uma vacina</h3>
    <form action="" method="post">
        nome: <input type="text" name="nome-add">
        quantidade: <input type="number" name="quantidade">
        <button type="submit" name="btn-adicionar">adicionar</button>
    </form>
    <?php
    if($resul != null){
        echo $resul;
    }
    ?>
    <br>
    <h3>Adiciona comorbidade a alguma vacina</h3>
    <h5>comorbidades disponiveis</h5>
    <ul>
    <?php
        $sqlComor = "SELECT nome FROM comorbidades;";
        $resultComor = mysqli_query($connect, $sqlComor);
        if(mysqli_num_rows($resultComor)>0){
           
            while($comor = mysqli_fetch_object($resultComor)){
                echo "<li>$comor->nome</li>";
            }
        }
        else{
            echo "não há comorbidades";
        }
        
        $sqlVac = "SELECT nome_vacina FROM vacina;";
        $resultVac = mysqli_query($connect, $sqlVac);

        if(isset($_POST['btn-addComor'])){
            $idVac = $_POST['nomVac'];
            $idComor = $_POST['nomComor'];
            $sqlEnv = "INSERT INTO comorbidades_vacina (vacina_id,comorbidade_id) VALUES ('$idVac','$idComor');";
            if(mysqli_query($connect,$sqlEnv)){
                $suce = 'deu certo';
            }
        }
    ?>
    </ul>
    <h4>Preencha</h4>
    <form action="" method="post">
        comorbidade: <input type="text" name="nomComor">
        <select name="nomVac" required="required">
            <?php
            if(mysqli_num_rows($resultVac) > 0){
            while($vacc = mysqli_fetch_object($resultVac)){
                    echo '<option value="'.$vacc->nome_vacina.'">'.$vacc->nome_vacina.'</option>';
                }
            }
            ?>
        </select>
        <button type="submit" name="btn-addComor">enviar</button>
    </form>
    <br>
    <?php
    if(isset($suce)){
        echo $suce;
    }


    if(isset($_POST['btn-toma'])){
        $selcVac = $_POST['nomVacin'];
        $sqlPro = "SELECT quantidade FROM vacina WHERE nome_vacina = '$selcVac'";
        $reccc = mysqli_query($connect, $sqlPro);
        if(mysqli_num_rows($reccc)>0){
            $a = mysqli_fetch_object($reccc);
            if($a->quantidade > 0){
                $quantVac = $a->quantidade - 1;
                $sqlUp = "UPDATE vacina SET quantidade = '$quantVac' WHERE nome_vacina = '$selcVac'";
                if(mysqli_query($connect,$sqlUp)){
                }
                else{
                    echo "nao enviou";
                }
            }
            else{
                echo "nao tem mais doses";
            }
            
        }
        
    }
    ?>
    <br>

    <h4>tome vacina</h4>
    <form action="" method="post">
        <select name="nomVacin" required="required">
            <?php
            $resultVaccc = mysqli_query($connect, $sqlVac);
            if(mysqli_num_rows($resultVaccc) > 0){
            while($vaccc = mysqli_fetch_object($resultVaccc)){
                    echo '<option value="'.$vaccc->nome_vacina.'">'.$vaccc->nome_vacina.'</option>';
                }
            }
            ?>
        </select>
        <button type="submit" name="btn-toma">enviar</button>
    </form>

    <br>
    <?php
    if(isset($_POST['btn-tomaa'])){
        $selcVacaa = $_POST['nomVacinaa'];
        $sqlDel = "DELETE FROM vacina WHERE nome_vacina = '$selcVacaa'";
        if(mysqli_query($connect, $sqlDel)){
            echo "deletado";
        }
        else{
            echo "nao deletou";
        }
    }
    ?>
    <h4>delete vacina</h4>
    <form action="" method="post">
        <select name="nomVacinaa" required="required">
            <?php
            $resultVacccc = mysqli_query($connect, $sqlVac);
            if(mysqli_num_rows($resultVaccc) > 0){
            while($vacccc = mysqli_fetch_object($resultVacccc)){
                    echo '<option value="'.$vacccc->nome_vacina.'">'.$vacccc->nome_vacina.'</option>';
                }
            }
            ?>
        </select>
        <button type="submit" name="btn-tomaa">enviar</button>
    </form>
    
</body>
</html>