<!DOCTYPE html>

<head>
    <title>Thony vs STARWARS</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="public/js/starwars.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>


    <style>
      * {
        font-family: Roboto;
      }
      
      .borda-direita{
          padding-right: 30px;
          padding-left: 30px;
          border-right: 1px solid black;
      }
    </style>
</head>

<body>
    <h1>Thony vs STARWARS!</h1>
    <p>Olá, seja bem vindo ao nosso teste.</p>
    <p>Iremos avaliar suas habilidades de JQuery e PHP através de uma comunicação com uma API Rest terceira.</p>
    <p>Você deve implementar uma aplicação que se comunique com a API do Star Wars.</p>
    <p>Toda a documentação pode ser encontrada no link <a target='_blank' href='https://swapi.co'>AQUI</a>.</p>
    <p>Você não pode utilizar <b><u>nenhum</u></b> outro framework além de JQuery.</p>

    <h3> Atividades Avaliadas: </h3>
    <div>
        <ul>
            <li>Ao clicar em cada botão, realizar uma consulta levando em consideração a entrada do usuário (quando necessário)</li>
            <li>Resultado deve ser impresso na tabela "Resultado" abaixo</li>
            <li>Utilizar CURL na parte do servidor para obter os resultados</li>
            <li>Usar jQuery para se comunicar com a controller e manipular o resultado obtido, organizando a tabela de resultado</li>
            <li><b>EXTRA</b>: Calcular a média (em dias) do atributo 'consumables' de todas as starships.
              <ul>
                <li>O atributo 'consumables' é disponibilizado pela API em formato de data por extenso, exemplo: 6 years ou 3 months.</li>
                <li>Você deve calcular a média e apresentá-la em dias.</li>
              </ul>
            </li>
        </ul>
    </div>

    <p>Obs: em caso de dúvida, sinta-se à vontade para nos enviar e-mail perguntando ou procurar no Google. </p>
    <h5>Boa sorte!</h5>
    <hr>

    <div>
        <label>Dado de Entrada</label>
        <br>
        <input id='entradaUsuario' type='text' placeholder="entrada do usuario">
        <br>
        <br>
        <button onclick='buscarPessoas();'> Buscar Todas as Pessoas </button>
        <button onclick='buscaPlanetaPorNome()'> Buscar Planetas por Nome </button>
        <button onclick='buscaNavePorID()'> Buscar Nave Por ID </button>
        <button onclick='calculaMediaCONSUMABLES()'> Calcular Média de CONSUMABLES</button>
    </div>

    <hr>

    <h2>Resultado</h2>
    <table>
        <thead id='tr-cabecalho'>
        </thead>
        <tbody id='tr-corpo'>
        </tbody>
    </table>
    <script>
        function buscarPessoas(){
            $('#tr-cabecalho').html("Carregando...");
            $('#tr-corpo').html("");
            $.ajax({
               url: "controllers/starwars_p.php?op=people",
               async: false
            }).done(function(){
                var cabecalho = '<tr><th class="borda-direita">Nome</th><th class="borda-direita">Altura (cm)</th><th class="borda-direita">Cor dos olhos</th></tr>';
                var elemento = "";
                $.getJSON('controllers/starwars_p.php?op=people', function(dadosJSON){
                    var cont = 0;
                    while(cont < 10){
                        elemento += "<tr><td class='borda-direita'>"+dadosJSON.results[cont].name+"</td><td class='borda-direita'>"+dadosJSON.results[cont].height+"</td><td class='borda-direita'>"+dadosJSON.results[cont].eye_color+"</td></tr>";
                        cont++;
                    }
                    $('#tr-cabecalho').html(cabecalho);
                    $('#tr-corpo').html(elemento);
                });
            }).fail(function(){
                alert("Erro ao buscar informações");
            });
        }
        
        function buscaPlanetaPorNome(){
            $('#tr-cabecalho').html("Carregando...");
            $('#tr-corpo').html("");
            var nomePlaneta = $('#entradaUsuario').val();
            $.ajax({
               url: "controllers/starwars_p.php?op=planets",
               async: false
            }).done(function(){
                var cabecalho = '<tr><th class="borda-direita">Nome</th><th class="borda-direita">Diametro</th><th class="borda-direita">População</th></tr>';
                var elemento = "";
                $.getJSON('controllers/starwars_p.php?op=planets', function(dadosJSON){
                    var cont = 0;
                    while(cont < 10){
                        if(dadosJSON.results[cont].name == nomePlaneta){
                            elemento += "<tr><td class='borda-direita'>"+dadosJSON.results[cont].name+"</td><td class='borda-direita'>"+dadosJSON.results[cont].diameter+"</td><td class='borda-direita'>"+dadosJSON.results[cont].population+"</td></tr>";
                        }
                        cont++;
                    }
                    if(elemento == ""){
                        $('#tr-cabecalho').html("Não foi encontrado planeta com o nome digitado");
                    } else{
                        $('#tr-cabecalho').html(cabecalho);
                        $('#tr-corpo').html(elemento);
                    }
                });
            }).fail(function(){
                alert("Erro ao buscar informações");
            });
        }
        
        function buscaNavePorID(){
            $('#tr-cabecalho').html("Carregando...");
            $('#tr-corpo').html("");
            var idNave = $('#entradaUsuario').val();
            if(idNave==""){
                alert("Você precisa digitar o ID da nave");
                $('#tr-cabecalho').html("");
            } else {
                $.ajax({
                   url: "controllers/starwars_p.php?op=starships&id="+idNave,
                   async: false
                }).done(function(){
                    var cabecalho = '<tr><th class="borda-direita">Nome</th><th class="borda-direita">Modelo</th><th class="borda-direita">Equipe técnica</th></tr>';
                    var elemento = "";
                    $.getJSON("controllers/starwars_p.php?op=starships&id="+idNave, function(dadosJSON){
                        elemento += "<tr><td class='borda-direita'>"+dadosJSON.name+"</td><td class='borda-direita'>"+dadosJSON.model+"</td><td class='borda-direita'>"+dadosJSON.crew+"</td></tr>";
                        $('#tr-cabecalho').html(cabecalho);
                        $('#tr-corpo').html(elemento);
                    });
                }).fail(function(){
                    alert("Erro ao buscar informações");
                });
            }
        }
        
        function calculaMediaCONSUMABLES(){
        $('#tr-cabecalho').html("Carregando...");
        $('#tr-corpo').html("");
        $.ajax({
                url: "controllers/starwars_p.php?op=consumables",
                async: false
            }).done(function(){
                var cabecalho = '<tr><th class="borda-direita">Média</th></tr>';
                var elemento = "";
                $.getJSON("controllers/starwars_p.php?op=consumables", function(dadosJSON){
                    elemento += "<tr><td class='borda-direita'>"+dadosJSON.media+"</td></tr>";
                    $('#tr-cabecalho').html(cabecalho);
                    $('#tr-corpo').html(elemento);
                });
            }).fail(function(){
                alert("Erro ao buscar informações");
            });
        }
    </script>
</body>
