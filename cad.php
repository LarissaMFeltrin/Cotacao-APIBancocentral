<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <h1> Conversor de Moedas</h1>
        <?php
        //Cotação da Api banco central
        $inicio = date("m-d-Y", strtotime("-8 days"));
        $fim = date("m-d-Y");
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $inicio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
        $dados = json_decode(file_get_contents($url), true);
        //var_dump($dados);
        $cotacao = $dados["value"][0]["cotacaoCompra"];

        //Quanto $$ você tem?
        $real = $_REQUEST["din"] ?? 0;

        //Equivalente em dólar
        $dolar = $real / $cotacao;

        //Mostra o resultado
        $padrão = numfmt_create("pt-BR", NumberFormatter::CURRENCY);
        echo "<p>Seus " . numfmt_format_currency($padrão, $real, "BRL") . " equivalem a <strong>" . numfmt_format_currency($padrão, $dolar, "USD") . "</strong></p>";
        ?>
        <button onclick="javascript:history.go(-1)">&#x2B05; Voltar</button>
    </main>
</body>

</html>