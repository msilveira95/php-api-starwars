<?php
class Starwars {
    public $urlStarWarsApi = "https://swapi.co/api/";

    function buscarPessoas(){
        $urlPeople = $this->urlStarWarsApi.'people/';
        $ch = curl_init($urlPeople);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }
    
    function buscarPlanetas(){
        $urlPlaneta = $this->urlStarWarsApi.'planets/';
        $ch = curl_init($urlPlaneta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }
    
    function buscarNavePorID($id){
        $urlNave = $this->urlStarWarsApi.'starships/'. $id . '/';
        $ch = curl_init($urlNave);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }
    
    function calculaMediaCONSUMABLES(){
        $urlNave = $this->urlStarWarsApi.'starships/';
        $ch = curl_init($urlNave);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dados = curl_exec($ch);
        $dados = json_decode($dados);
        $valor = 0;
        foreach($dados->results as $linha){
            if(strpos($linha->consumables, "days")){
                $valor = $valor + preg_replace("/[^0-9]/", "", $linha->consumables);
            } else if(strpos($linha->consumables, "week")){
                $valor = $valor + preg_replace("/[^0-9]/", "", $linha->consumables)*7;
            } else if(strpos($linha->consumables, "month") || strpos($linha->consumables, "months")){
                $valor = $valor + preg_replace("/[^0-9]/", "", $linha->consumables)*30;
            } else if(strpos($linha->consumables, "year") || strpos($linha->consumables, "years")){
                $valor = $valor + preg_replace("/[^0-9]/", "", $linha->consumables)*365;
            }
        }
        return $valor/10;
    }
}
?>
