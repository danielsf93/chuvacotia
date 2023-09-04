<?php
// CONSULTANDO OS DADOS ONLINE:

$url = 'http://sjc.salvar.cemaden.gov.br/resources/graficos/interativo/getJson2.php?uf=SP';

$headers = ['Content-type: application/json', 'Accept: application/json'];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Erro ao fazer a solicitação HTTP: ' . curl_error($ch);
    exit;
}

curl_close($ch);

$text = json_decode($response, true);

// Cidades desejadas
$cidadesDesejadas = [
    'Rio Cotia',
    'Parque Miguel Mirizola',
    'Monte Catine',
    'Morro Grande',
    'Jardim Adelina',
    'Caucaia do Alto',
    'Santa Isabel',
    
    // Adicione outras cidades desejadas aqui
];

// Criar um array associativo para armazenar os valores de acumulado
$acumulado = [];

// Preencher o array associativo com os valores disponíveis
foreach ($text as $item) {
    $cidade = $item['nomeestacao'];
    $acc1hr = $item['acc1hr'];
    $acc3hr = $item['acc3hr'];
    $acc6hr = $item['acc6hr'];
    $acc12hr = $item['acc12hr'];
    $acc24hr = $item['acc24hr'];
    $acc48hr = $item['acc48hr'];
    $acc72hr = $item['acc72hr'];
    $acc96hr = $item['acc96hr'];
    
    $acumulado[$cidade] = [
        'acc1hr' => $acc1hr,
        'acc3hr' => $acc3hr,
        'acc6hr' => $acc6hr,
        'acc12hr' => $acc12hr,
        'acc24hr' => $acc24hr,
        'acc48hr' => $acc48hr,
        'acc72hr' => $acc72hr,
        'acc96hr' => $acc96hr,
    ];
}

// Exibir os valores de acumulado de chuva para as cidades desejadas
foreach ($cidadesDesejadas as $cidadeDesejada) {
    $valores = isset($acumulado[$cidadeDesejada]) ? $acumulado[$cidadeDesejada] : [
        'acc1hr' => '-',
        'acc3hr' => '-',
        'acc6hr' => '-',
        'acc12hr' => '-',
        'acc24hr' => '-',
        'acc48hr' => '-',
        'acc72hr' => '-',
        'acc96hr' => '-',
    ];
    
    echo "$cidadeDesejada \t {$valores['acc1hr']} \t {$valores['acc3hr']} \t {$valores['acc6hr']} \t {$valores['acc12hr']} \t {$valores['acc24hr']} \t {$valores['acc48hr']} \t {$valores['acc72hr']} \t {$valores['acc96hr']} <br>";
}
?>
