<?php
    require_once '../models/Starwars.php';
    // documentação da api star wars: https://swapi.co/
    switch($_GET['op']){
        case 'people':
            $people = new Starwars();
            $dados = $people->buscarPessoas();
            echo $dados;
            break;
        case 'planets':
            $planeta = new Starwars();
            $dados = $planeta->buscarPlanetas();
            echo $dados;
            break;
        case 'starships':
            $nave = new Starwars();
            $dado = $nave->buscarNavePorID($_GET['id']);
            echo $dado;
            break;
        case 'consumables':
            $consumables = new Starwars();
            $media = $consumables->calculaMediaCONSUMABLES();
            echo '{"media": "'.$media.'"}';
            break;
    }    
    
?>
