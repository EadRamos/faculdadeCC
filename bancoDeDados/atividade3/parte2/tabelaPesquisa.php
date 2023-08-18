<div>
    <h3>Resultado da pesquisa</h3>
    <ul>
    <?php
    foreach ($comorbidades as $key => $comorbidade) {
        echo "<li>$comorbidade->nome</li>";
    }
    ?>
    </ul>
</div>