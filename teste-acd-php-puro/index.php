<?php

$clientes = array(
    [
        'nome' => 'Nome do Cliente 1',
        'telefone' => '(11) 99442-8533',
        'plano' => 'TV 30 dias',
        'vencimento' => '01/01/2023'
    ], [
        'nome' => 'Nome do Cliente 2 ',
        'telefone' => '(11) 99442-8533',
        'plano' => 'Filmes 30 dias 3',
        'vencimento' => '01/01/2023'
        
    ], [
        'nome' => 'Nome do Cliente 4',
        'telefone' => '(11) 99442-8533',
        'plano' => 'TV 90 dias',
        'vencimento' => '01/01/2023'
    ], [
        'nome' => 'Nome do Cliente 5',
        'telefone' => '(11) 99442-8533',
        'plano' => 'Filmes 90 dias',
        'vencimento' => '01/01/2023'
    ]
);

$pixNumber = " (xx) 12312-1323";

foreach ($clientes as $cliente) {
    $formattedPhone = str_replace(['(', ')', ' ', '-'], '', $cliente['telefone']);
    $formattedPhone = '+55' . $formattedPhone;

    $message = sprintf(
        'Olá %s, informamos que seu plano venceu hoje %s. Renove seu plano agora mesmo através da tabela de valores abaixo: (imagem) Para renovar basta fazer o Pix para %s',
        $cliente['nome'],
        $cliente['vencimento'],
        $pixNumber
    );
    
    $apiUrl = 'https://api.callmebot.com/whatsapp.php';
    $apiKey = '8899987';

    $url = sprintf(
        '%s?phone=%s&text=%s&apikey=%s',
        $apiUrl,
        $formattedPhone,
        urlencode($message),
        $apiKey
    );

    try {
        $response = file_get_contents($url);

        if ($response === false) {
            throw new Exception('Error making API request to callmebot.');
        }

        echo 'Message sent to: ' . $formattedPhone . "<br>";
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage() . "<br>";
    }
}
?>
