<?php

use App\Models\Configuracao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;


if (!function_exists('user')) {
    function user(): ?User
    {
        return Auth::user();
    }
}


function formatarCnpjCpf($value)
{
    $CPF_LENGTH = 11;
    $cnpj_cpf = preg_replace("/\D/", '', $value);

    if (strlen($cnpj_cpf) === $CPF_LENGTH) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    }

    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function unformatCpfCnpj(string $value)
{
    return preg_replace('/[^0-9]/', '', $value);
}

function limparCpfCnpj(string $value)
{
    return preg_replace('/[^0-9]/', '', $value);
}

function formatarDinheiro($value, $setPrefix = false, $prefix = 'R$ ')
{
    if ($setPrefix) {
        return $prefix . number_format($value, 2, ',', '.');
    }
    return number_format($value, 2, ',', '.');
}

function formatarDinheiroPorExtenso(float $valor)
{
    if ($valor == 0) {
        return 'zero reais';
    }

    return (new NumeroPorExtenso)->converter($valor);
}

function formatarDataPorExtenso(string $data)
{
    $data = explode('-', $data);
    $dia = $data[2];
    $mes = $data[1];
    $ano = $data[0];

    $meses = [
        '01' => 'janeiro',
        '02' => 'fevereiro',
        '03' => 'março',
        '04' => 'abril',
        '05' => 'maio',
        '06' => 'junho',
        '07' => 'julho',
        '08' => 'agosto',
        '09' => 'setembro',
        '10' => 'outubro',
        '11' => 'novembro',
        '12' => 'dezembro',
    ];

    return $dia . ' de ' . $meses[$mes] . ' de ' . $ano;
}


function formatarDataPorExtenso2($date = null)
{
    date_default_timezone_set('America/Sao_Paulo');

    if ($date != null) {
        $data = new DateTime($date);
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN
        );

        return $formatter->format($data);
    }
}

$date = new \DateTime();
$formatter = new \IntlDateFormatter(
    'pt_BR',
    \IntlDateFormatter::FULL,
    \IntlDateFormatter::NONE,
    'America/Sao_Paulo',
    \IntlDateFormatter::GREGORIAN
);

return $formatter->format($date);

function dataAtualPorExtenso(
    $date = null,
    $format = 'd \d\e F \d\e Y',
    $locale = 'pt_BR',
    $timezone = 'America/Sao_Paulo',
    $calendar = 'gregorian'

) {

    if ($date != null) {
        $data = new DateTime($date);
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN
        );

        return $formatter->format($data);
    }


    $date = new \DateTime();
    $formatter = new \IntlDateFormatter(
        'pt_BR',
        \IntlDateFormatter::FULL,
        \IntlDateFormatter::NONE,
        'America/Cuiaba',
        \IntlDateFormatter::GREGORIAN
    );

    return $formatter->format($date);

    // function getPrimeirasLetras($string, $length = 10)
    // {
    //     $string = strip_tags($string);
    //     $string = trim($string);
    //     $string = mb_substr($string, 0, $length);
    //     $string = rtrim($string, "!,.-");
    //     $string = substr($string, 0, strrpos($string, ' '));
    //     return $string . "...";
    // }


}

function getAno()
{
    $date = new \DateTime();
    $formatter = new \IntlDateFormatter(
        'pt_BR',
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE,
        'America/Cuiaba',
        \IntlDateFormatter::GREGORIAN
    );

    return $formatter->format($date);
}

function getPrimeiraLetraDoNomeESobrenome(string $nome): string
{
    $nome = explode(' ', $nome);
    $primeiroNome = $nome[0];
    $ultimoNome = $nome[count($nome) - 1];
    $primeiraLetraDoNomeESobrenome = $primeiroNome . ' ' . $ultimoNome;
    return $primeiraLetraDoNomeESobrenome;
}


function gerarUsername($data)
{
    // SEPARAR OS NOME POR ESPAÇO
    $username = explode(' ', $data['name']);
    $validated['username'] = strtolower($data[0] . '.' . count($username) > 1 ?? count($username) - 1);
    $primeiroNome = $username[0];
    $ultimoNome = $username[count($username) - 1];
    $nomeCompleto = $primeiroNome . ' ' . $ultimoNome;
    $validated['username'] = strtolower($primeiroNome . '.' . $ultimoNome);
}

function chave($chave)
{
    $chave = Configuracao::query()
        ->where('chave', '=', $chave)
        ->first()->valor;

    return $chave;
}


function to_array($value)
{
    return json_decode(json_encode($value), true);
}

function to_object($value)
{
    return json_decode(json_encode($value));
}

function to_collection($value)
{
    return collect(to_array($value));
}

function removerArrayVazio(array $data)
{
    return array_map(function ($value) {
        return array_filter($value, 'strlen');
    }, $data);
}

function formatarTelefone($telefone)
{
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    $telefone = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
    return $telefone;
}


function is_multi_array(array $arr)
{
    rsort($arr);
    return isset($arr[0]) && is_array($arr[0]);
}

/**
 * Retorna o nome do arquivo a partir de uma url
 *
 * @param string $url
 * @return string
 */
function get_file_name($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $path = explode('/', $path);
    return end($path);
}

function download_file($url, $destino)
{
    $file = file_get_contents($url);
    file_put_contents($destino, $file);
}

function criarDiretorio($diretorio)
{
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }
}

function getNomeDoArquivo($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $path = explode('/', $path);
    return end($path);
}

function getExtensaoNomeArquivo($nome)
{
    return pathinfo($nome, PATHINFO_EXTENSION);
}

function wrap($method)
{
    return $method . 'WSResp';
}

function responseXML($response)
{
    return simplexml_load_string($response);
}

/**
 * Converte SimpleXMLElement para string ou null se vazio
 */
function simpleXMLtoString($xmlElement): ?string
{
    $value = (string) ($xmlElement ?? '');
    return filled($value) ? $value : null;
}

function realParaCentavo($valor)
{
    if ($valor == 0) {
        return 0;
    }

    return $valor * 100;
}


/**
 * Garante que o retorno seja sempre um array, mesmo que tenha apenas 1 item.
 */
function normalizarArray(mixed $data): array
{
    // ✅ DEBUG: Ver o que está entrando
    Log::info('DEBUG: normalizarArray - ENTRADA', [
        'data_type' => gettype($data),
        'data_content' => $data,
        'is_array' => is_array($data),
        'is_object' => is_object($data),
    ]);

    if (is_array($data)) {
        // ✅ DEBUG: Se já é array, ver o conteúdo
        Log::info('DEBUG: normalizarArray - É ARRAY', [
            'count' => count($data),
            'first_item' => !empty($data) ? $data[0] : 'empty',
            'first_item_type' => !empty($data) ? gettype($data[0]) : 'empty',
            'first_item_IDAnexo' => !empty($data) && isset($data[0]->IDAnexo) ? $data[0]->IDAnexo : 'not_found'
        ]);
        return $data;
    }

    if (is_object($data)) {
        // ✅ DEBUG: Se é objeto único, ver propriedades
        Log::info('DEBUG: normalizarArray - É OBJETO', [
            'object_properties' => get_object_vars($data),
            'IDAnexo' => $data->IDAnexo ?? 'not_found',
        ]);

        $resultado = [$data];

        // ✅ DEBUG: Verificar após conversão
        Log::info('DEBUG: normalizarArray - APÓS CONVERSÃO', [
            'resultado_count' => count($resultado),
            'primeiro_item' => $resultado[0],
            'IDAnexo_preservado' => $resultado[0]->IDAnexo ?? 'lost'
        ]);

        return $resultado;
    }

    Log::warning('DEBUG: normalizarArray - RETORNANDO ARRAY VAZIO', [
        'data_type' => gettype($data),
        'data' => $data
    ]);

    return []; // ou lança exceção se quiser forçar
}
// if (!function_exists('extrairArray')) {
function extrairArray(object|array|null $origem, string $caminho): array
{
    if (!$origem) return [];

    $partes = explode('.', $caminho);
    $atual = $origem;

    foreach ($partes as $parte) {
        if (is_array($atual) && isset($atual[$parte])) {
            $atual = $atual[$parte];
        } elseif (is_object($atual) && isset($atual->$parte)) {
            $atual = $atual->$parte;
        } else {
            return [];
        }
    }

    return is_object($atual) ? [$atual] : (is_array($atual) ? $atual : []);
}

function safeArrayToString($value)
{
    return is_array($value) ? ($value[0] ?? null) : $value;
}

function extrairPrimeiroValor($valor): ?string
{
    if (is_array($valor)) {
        return $valor[0] ?? null;
    }
    return $valor;
}


function limparNomeArquivo(string $fileName): string
{
    // Remove caracteres problemáticos
    $fileName = preg_replace('/[\/\\:*?"<>|]/', '_', $fileName);

    // Remove espaços duplos
    $fileName = preg_replace('/\s+/', ' ', $fileName);

    // Remove pontos no final
    $fileName = rtrim($fileName, '.');

    return trim($fileName);
}
