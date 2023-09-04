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

// Criar um array associativo para armazenar os valores de acumulado e ultimovalor
$dadosCidades = [];

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
    $ultimovalor = $item['ultimovalor'];
    
    $dadosCidades[$cidade] = [
        'ultimovalor' => $ultimovalor,
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Acumulado de Chuva</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>Cidade</th>
            <th>Último Valor</th>
            <th>1hr</th>
            <th>3hr</th>
            <th>6hr</th>
            <th>12hr</th>
            <th>24hr</th>
            <th>48hr</th>
            <th>72hr</th>
            <th>96hr</th>
        </tr>
        <?php foreach ($cidadesDesejadas as $cidadeDesejada) : ?>
            <tr>
                <td><?php echo $cidadeDesejada; ?></td>
                <?php
                $valores = isset($dadosCidades[$cidadeDesejada]) ? $dadosCidades[$cidadeDesejada] : [
                    'ultimovalor' => '-',
                    'acc1hr' => '-',
                    'acc3hr' => '-',
                    'acc6hr' => '-',
                    'acc12hr' => '-',
                    'acc24hr' => '-',
                    'acc48hr' => '-',
                    'acc72hr' => '-',
                    'acc96hr' => '-',
                ];
                ?>
                <td><?php echo $valores['ultimovalor']; ?></td>
                <td><?php echo $valores['acc1hr']; ?></td>
                <td><?php echo $valores['acc3hr']; ?></td>
                <td><?php echo $valores['acc6hr']; ?></td>
                <td><?php echo $valores['acc12hr']; ?></td>
                <td><?php echo $valores['acc24hr']; ?></td>
                <td><?php echo $valores['acc48hr']; ?></td>
                <td><?php echo $valores['acc72hr']; ?></td>
                <td><?php echo $valores['acc96hr']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
