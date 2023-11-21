<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = 'https://api.callmebot.com/whatsapp.php';
        $this->apiKey = '8899987';
    }

    public function sendMessages()
    {
        $clientes = [
            [
                'nome' => 'Nome do Cliente 1',
                'telefone' => '(11) 99442-8533',
                'plano' => 'TV 30 dias',
                'vencimento' => '01/01/2023'
            ],
            [
                'nome' => 'Nome do Cliente 2',
                'telefone' => '(11) 99442-8533',
                'plano' => 'Filmes 30 dias 3',
                'vencimento' => '01/01/2023'
            ],
            [
                'nome' => 'Nome do Cliente 4',
                'telefone' => '(11) 99442-8533',
                'plano' => 'TV 90 dias',
                'vencimento' => '01/01/2023'
            ],
            [
                'nome' => 'Nome do Cliente 5',
                'telefone' => '(11) 99442-8533',
                'plano' => 'Filmes 90 dias',
                'vencimento' => '01/01/2023'
            ]
        ];

        foreach ($clientes as $cliente) {
            $message = $this->buildMessage($cliente);
            $formattedPhone = $this->formatPhone($cliente['telefone']);

            try {
                $this->sendMessage($formattedPhone, $message);
                echo 'Message sent to: ' . $cliente['telefone'] . "<br>";
            } catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage() . "<br>";
            }
        }
    }

    private function formatPhone(string $phone){
        $formattedPhone = str_replace(['(', ')', ' ', '-'], '', $phone);
        $formattedPhone = '+55' . $formattedPhone;
        return $formattedPhone;
    }

    private function buildMessage(array $cliente): string
    {
        return sprintf(
            'Olá %s, informamos que seu plano venceu hoje %s. Renove seu plano agora mesmo através da tabela de valores abaixo: [Link para a imagem] Para renovar basta fazer o Pix para %s',
            $cliente['nome'],
            $cliente['vencimento'],
            '(xx) 12312-1323'
        ) . "\n\n[Link para a imagem: https://example.com/image.jpg]";
    }

    private function sendMessage(string $phoneNumber, string $message): void
    {
        $response = Http::get($this->apiUrl, [
            'phone' => $phoneNumber,
            'text' => $message,
            'apikey' => $this->apiKey,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Error making API request to callmebot.');
        }
    }
}
