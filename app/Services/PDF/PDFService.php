<?php

namespace App\Services\PDF;

use Imagick;
use Exception;
use Mpdf\QrCode\QrCode;
use iio\libmergepdf\Merger;
use Mpdf\QrCode\Output\Png;
use setasign\Fpdi\Tcpdf\Fpdi;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Log;

class PDFService
{
    // Caminho para a logo (ajuste conforme sua estrutura)
    private static $logoPath = null;

    /**
     * Define o caminho da logo
     */
    public static function setLogoPath(string $path): void
    {
        self::$logoPath = $path;
    }

    /**
     * Adiciona cabeçalho completo (logo + texto) usando Imagick
     */
    private static function adicionarCabecalhoImagick(\Imagick $canvas): void
    {
        if (!self::$logoPath || !file_exists(self::$logoPath)) {
            Log::warning('Logo não encontrada no caminho: ' . self::$logoPath);
            return;
        }

        try {
            // Criar área do cabeçalho com fundo branco
            $cabecalho = new \Imagick();
            $cabecalho->newImage(1654, 120, new \ImagickPixel('white'));
            $cabecalho->setImageFormat('png');


            // Compor o cabeçalho na página
            $canvas->compositeImage($cabecalho, \Imagick::COMPOSITE_OVER, 0, 0);

            $cabecalho->clear();
            $cabecalho->destroy();
        } catch (Exception $e) {
            Log::error('Erro ao adicionar cabeçalho com Imagick: ' . $e->getMessage());
        }
    }

    /**
     * Adiciona cabeçalho completo (logo + texto) usando FPDI
     */
    private static function adicionarCabecalhoFPDI($pdf, $pageWidth, $pageHeight, $dados = []): void
    {
        if (!self::$logoPath || !file_exists(self::$logoPath)) {
            Log::warning('Logo não encontrada no caminho: ' . self::$logoPath);
            return;
        }

        Log::info('Adicionando cabeçalho com FPDI', [
            'dados' => $dados
        ]);

        try {
            $logoWidth = 60;     // Era 70, agora 60 - menor sem deformação
            $logoHeight = 0;     // Mantém proporção automática

            // Posicionar logo MAIS no TOPO (só a imagem sobe)
            $logoX = 20;  // Era 10, agora 15 - imagem mais à direita
            $logoY = 0;   // Era 5, agora 0 - só a imagem sobe mais

            $pdf->Image(self::$logoPath, $logoX, $logoY, $logoWidth, $logoHeight);

            // Adicionar texto do cartório (ao lado da logo) - AINDA MAIS no TOPO
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->SetTextColor(0, 0, 0);

            // Título principal
            $pdf->SetXY(75, 7);   // Era 10, agora 7 - ainda mais no topo
            $pdf->Cell(0, 5, '1 OFÍCIO DE REGISTRO DE IMÓVEIS, TÍTULOS E DOCUMENTOS DE SINOP - MT', 0, 1, 'L');

            $pdf->SetFont('helvetica', '', 8);

            // Código Nacional
            $pdf->SetXY(75, 13);  // Era 16, agora 13 - ainda mais no topo
            $pdf->Cell(0, 4, 'Código Nacional de Serventias do CNJ: 06.552-4', 0, 1, 'L');

            // Telefone/Fax
            $pdf->SetXY(75, 17);  // Era 20, agora 17 - ainda mais no topo
            $pdf->Cell(0, 4, 'Telefone: (66) 3531-2501 - Celular/WhatsApp: (66) 9.9930-9137', 0, 1, 'L');

            // Website e email
            $pdf->SetXY(75, 21);  // Era 24, agora 21 - ainda mais no topo
            $pdf->Cell(0, 4, 'www.1oficiosinop.com.br - atendimento@1oficiosinop.com.br', 0, 1, 'L');

            $pdf->SetXY(75, 25);  // Era 24, agora 25 - ainda mais no topo
            $pdf->Cell(0, 4, 'Pedido de Solicitação (SAEC/RI Digital) nº: ' . $dados['data']['protocolo_solicitacao'], 0, 1, 'L');
        } catch (Exception $e) {
            Log::error('Erro ao adicionar cabeçalho com FPDI: ' . $e->getMessage());
        }
    }

    public static function converterTiffParaPdf(string $caminhoTif, string $bucketPath = 'documentos/protegido', $data = []): string
    {
        // Definir o caminho da logo se não foi definido
        if (self::$logoPath === null) {
            self::$logoPath = public_path('/assets/images/logo_ribr.png'); // Ajuste o caminho
        }

        $larguraA4 = 1654;
        $alturaA4 = 2339;

        $paginasOriginal = new \Imagick();
        $paginasOriginal->readImage($caminhoTif);

        $documentoFinal = new \Imagick();
        $documentoFinal->setResolution(200, 200);

        $escalaLargura = 0.70;
        $totalPaginas = count($paginasOriginal);

        foreach ($paginasOriginal as $index => $pagina) {
            $pagina->setImageResolution(200, 200);
            $pagina->setImageFormat('png');
            $pagina->setImageCompression(\Imagick::COMPRESSION_UNDEFINED);

            $novaLargura = (int)($larguraA4 * $escalaLargura);
            $pagina->resizeImage($novaLargura, 0, \Imagick::FILTER_LANCZOS, 1);

            $canvas = new \Imagick();
            $canvas->newImage($larguraA4, $alturaA4, new \ImagickPixel('white'));
            $canvas->setImageFormat('jpeg');

            $posX = (int)(($larguraA4 - $novaLargura) / 2);
            $posY = 300; // Desceu ainda mais a imagem do TIFF
            $canvas->compositeImage($pagina, \Imagick::COMPOSITE_OVER, $posX, $posY);

            // ADICIONAR CABEÇALHO COMPLETO EM CADA PÁGINA
            self::adicionarCabecalhoImagick($canvas);

            // SE FOR A ÚLTIMA PÁGINA, ADICIONAR LINHA DIAGONAL DE SEGURANÇA
            // if ($index === $totalPaginas - 1) {
            //   self::adicionarLinhaDiagonalSeguranca($canvas, $larguraA4, $alturaA4, $posY, $novaLargura);
            // }

            if ($index === $totalPaginas - 1) {
                $ultimaImagem = clone $canvas;
            } else {
                $documentoFinal->addImage($canvas);
            }
        }

        $preview = clone $ultimaImagem;
        $preview->transformImageColorspace(\Imagick::COLORSPACE_GRAY);
        $preview->thresholdImage(0.9 * \Imagick::getQuantumRange()['quantumRangeLong']);
        $preview->cropImage($larguraA4, 400, 0, $alturaA4 - 400);
        $preview->resizeImage(100, 10, \Imagick::FILTER_LANCZOS, 1);

        $maxWhite = 0;
        $bestX = 0;
        $bestY = 0;
        for ($y = 0; $y < 10; $y++) {
            for ($x = 0; $x < 100; $x++) {
                $pixel = $preview->getImagePixelColor($x, $y);
                $value = $pixel->getColor()['r'];
                if ($value > $maxWhite) {
                    $maxWhite = $value;
                    $bestX = $x;
                    $bestY = $y;
                }
            }
        }
        $px = (int)($larguraA4 * $bestX / 100) - 250;
        $py = (int)($alturaA4 - 300);

        $documentoFinal->addImage($ultimaImagem);

        $documentoFinal->setImageFormat('pdf');
        $nomeTemporario = 'matricula_intermediaria_' . uniqid() . '.pdf';
        $caminhoTemporario = storage_path("app/{$bucketPath}/{$nomeTemporario}");

        if (!file_exists(dirname($caminhoTemporario))) {
            mkdir(dirname($caminhoTemporario), 0777, true);
        }

        $documentoFinal->writeImages($caminhoTemporario, true);

        $paginasOriginal->clear();
        $documentoFinal->clear();

        $textoQrCode = "https://gif.tjmt.jus.br/selo/Consulta/ConSeloDigitalExterno.aspx?nselo={$data['integrado_selo_prefixo']}-{$data['integrado_selo_numero']}";
        $qrCode = self::qrCode($textoQrCode);

        // Mescla com a página de certificação via SnappyPDF
        return self::adicionarPaginaAdicional(
            $caminhoTemporario,
            'cartorio.certidao.02_carimbo_certidao_automatica',
            compact('data', 'qrCode'),
        );
    }

    public static function adicionarPaginaAdicional(string $pdfOriginal, string $bladeView, array $dados = [], string $bucketPath = 'documentos/protegido'): string
    {
        // Definir o caminho da logo se não foi definido
        if (self::$logoPath === null) {
            self::$logoPath = public_path('/assets/images/logo_ribr.png'); // Ajuste o caminho
        }

        // Gera PDF da view Blade
        $html = view($bladeView, $dados)->render();

        $paginaCertificacao = SnappyPdf::loadHTML($html)
            ->setPaper('a4')
            ->setOption('dpi', 300)
            ->setOption('image-quality', 100)
            ->setOption('zoom', 1.10)
            ->output();



        // Faz merge dos dois PDFs mantendo a qualidade
        $merger = new Merger();
        $merger->addFile($pdfOriginal);
        $merger->addRaw($paginaCertificacao);

        $mergedPdf = $merger->merge();

        // Salva temporariamente o PDF mesclado para aplicar a numeração
        $mergedTemp = tempnam(sys_get_temp_dir(), 'merged_pdf_') . '.pdf';
        file_put_contents($mergedTemp, $mergedPdf);

        try {
            // Adiciona numeração, frase de validade e LOGO no rodapé
            $pdf = new Fpdi('P', 'mm', 'A4', true, 'UTF-8', false, 3);

            // ✅ ALTERAR PDF/A VERSION usando Reflection
            $reflection = new \ReflectionClass($pdf);

            // Alterar a versão PDF/A
            $pdfaVersionProperty = $reflection->getProperty('pdfa_version');
            $pdfaVersionProperty->setAccessible(true);
            $pdfaVersionProperty->setValue($pdf, 3); // PDF/A-2 (ou 1 para PDF/A-1, 3 para PDF/A-3)

            // Reconfigurar a versão PDF baseada na nova versão PDF/A
            $pdf->setPDFVersion('1.7'); // Agora será respeitada a versão 2




            $pdf->SetAutoPageBreak(false);

            // Título dinâmico
            $numeroMatricula = $dados['data']['certidao_matricula_numero'] ?? 'N/A';
            // Data atual para o assunto
            $seloPrefixo = $dados['data']['integrado_selo_prefixo'] ?? 'N/A';
            $seloNumero = $dados['data']['integrado_selo_numero'] ?? 'N/A';
            $dataSelo = date('d/m/Y', strtotime($dados['data']['integrado_selo_data']));
            $horaSelo = date('H:i', strtotime($dados['data']['integrado_selo_hora']));
            $dataEmissao = $dataSelo . ' às ' . $horaSelo;
            $assunto = "Certidão de Inteiro Teor de Imóvel - Emitida em {$dataEmissao}";
            $seloDigital = "Selo Digital: {$seloPrefixo}-{$seloNumero}";

            $titulo = "Certidão de Inteiro Teor - Matrícula nº {$numeroMatricula} - {$seloDigital}";

            $keywords = 'matrícula nº ' . $numeroMatricula . ', ' . $seloDigital . ', certidão, registro de imóveis, matrícula, inteiro teor, Sinop, Mato Grosso';

            $pdf->SetCreator('1º Ofício de Registro de Imóveis de Sinop - MT - CNS: 06.552-4');
            $pdf->SetAuthor('André Luís Giocondo - Registrador');
            $pdf->SetTitle($titulo);
            $pdf->SetSubject($assunto);
            $pdf->SetKeywords($keywords);


            // ✅ DESABILITAR HEADERS/FOOTERS AUTOMÁTICOS
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(0);

            $pageCount = $pdf->setSourceFile($mergedTemp);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplIdx = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($tplIdx);

                if ($size['width'] > $size['height']) {
                    $pdf->AddPage('L');
                } else {
                    $pdf->AddPage('P');
                }

                $pdf->useTemplate($tplIdx);

                self::adicionarCabecalhoFPDI($pdf, $size['width'], $size['height'], $dados);

                $margemLateral = 20;
                $larguraTotal = $size['width'] - ($margemLateral * 2);

                // Começar de uma posição mais baixa para acomodar os elementos ABAIXO do selo
                $posicaoAtual = $size['height'] - 35; // ERA 30, AGORA 35 - só um pouco mais de espaço

                // CONTRADITÓRIO EM VERMELHO (se existir) - PRIMEIRO
                $textoContraditorio = self::textoContraditorio($dados);

                if (!empty($textoContraditorio)) {
                    $pdf->SetFont('helvetica', 'B', 8);
                    $pdf->SetTextColor(255, 0, 0); // VERMELHO

                    // Texto completo: "OBSERVAÇÃO: texto"
                    $textoCompleto = 'OBSERVAÇÃO: ' . $textoContraditorio;

                    // Quebrar o texto em linhas
                    $larguraSegura = $larguraTotal - 10;
                    $linhas = self::splitTextToLines($textoCompleto, $larguraSegura);

                    $alturaLinha = 4; // MANTÉM 4 - menos espaçamento entre linhas
                    $posicaoYTexto = $posicaoAtual;

                    foreach ($linhas as $linha) {
                        $pdf->SetXY($margemLateral, $posicaoYTexto);
                        $pdf->Cell($larguraTotal, $alturaLinha, trim($linha), 0, 0, 'L');
                        $posicaoYTexto += $alturaLinha;
                    }

                    // Atualizar posição para os próximos elementos
                    $posicaoAtual = $posicaoYTexto + 3; // DIMINUI DE 8 PARA 3 - menos espaço
                }

                // FRASE DE VALIDADE - volta ao normal
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->SetTextColor(0, 0, 0);

                $fraseValidade = 'ESTA CERTIDÃO TEM VALIDADE DE 30 DIAS APÓS A DATA DE EMISSÃO';

                if ($posicaoAtual > $size['height'] - 20) {
                    $posicaoAtual = $size['height'] - 20;
                }

                // Desenhar caixa com borda para a frase de validade - MAIS COMPACTA
                $pdf->SetXY($margemLateral, $posicaoAtual);
                $pdf->SetDrawColor(0, 0, 0); // Borda preta
                $pdf->SetFillColor(255, 255, 255); // Fundo branco
                $pdf->SetLineWidth(0.3);
                $pdf->Cell($larguraTotal, 6, $fraseValidade, 1, 0, 'C', true); // DIMINUI ALTURA DE 8 PARA 6

                // NUMERAÇÃO - ABAIXO DA FRASE DE VALIDADE
                $pdf->SetFont('helvetica', '', 9); // DIMINUI DE 10 PARA 9
                $pdf->SetTextColor(0, 0, 0);

                $numeroTexto = sprintf('Página %04d/%04d', $pageNo, $pageCount);

                // Desenhar caixa com borda para a numeração - MAIS COMPACTA
                $pdf->SetXY($margemLateral, $posicaoAtual + 8); // DIMINUI ESPAÇO DE 10 PARA 8
                $pdf->SetDrawColor(0, 0, 0); // Borda preta
                $pdf->SetFillColor(255, 255, 255); // Fundo branco
                $pdf->SetLineWidth(0.3);
                $pdf->Cell($larguraTotal, 6, $numeroTexto, 1, 0, 'C', true); // DIMINUI ALTURA DE 8 PARA 6

                // RESET após adicionar os elementos
                $pdf->SetDrawColor(255, 255, 255);
                $pdf->SetLineWidth(0);
            }

            $nomeFinal = 'matricula_final_com_certificacao_' . uniqid() . '.pdf';
            $pathLocal = storage_path("app/{$bucketPath}/{$nomeFinal}");

            if (!file_exists(dirname($pathLocal))) {
                mkdir(dirname($pathLocal), 0777, true);
            }

            $pdf->Output($pathLocal, 'F');
            unlink($mergedTemp);

            return $pathLocal;
        } catch (Exception $e) {
            if (file_exists($mergedTemp)) {
                unlink($mergedTemp);
            }
            throw $e;
        }
    }


    private static function splitTextToLines($text, $maxWidth, $pdf = null)
    {
        if (!$pdf) {
            $pdf = new Fpdi('P', 'mm', 'A4', true, 'UTF-8', false, true);
            $pdf->SetFont('helvetica', '', 8); // Mudei para helvetica
        }

        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine . ($currentLine ? ' ' : '') . $word;

            if ($pdf->GetStringWidth($testLine) <= $maxWidth) {
                $currentLine = $testLine;
            } else {
                if ($currentLine) {
                    $lines[] = $currentLine;
                    $currentLine = $word;
                } else {
                    // Palavra muito longa, quebra forçadamente
                    $lines[] = $word;
                }
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }

        return $lines;
    }

    private static function textoContraditorio(array $dados): string
    {
        // Log para debug
        Log::info('Verificando contraditório', [
            'contraditorio_debug' => $dados['data']['contraditorio_debug'] ?? 'não definido'
        ]);

        // Verificar se existe contraditório no campo correto
        if (empty($dados['data']['contraditorio_debug'])) {
            return '';
        }

        $contraditorio = $dados['data']['contraditorio_debug'];

        // Se for uma string (JSON), decodificar
        if (is_string($contraditorio)) {
            $contraditorio = json_decode($contraditorio, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Erro ao decodificar JSON do contraditório', ['error' => json_last_error_msg()]);
                return '';
            }
        }

        // Se for um array de protocolos
        if (is_array($contraditorio)) {
            $protocolos = [];

            foreach ($contraditorio as $item) {
                if (is_array($item)) {
                    // Extrair informações do protocolo
                    $protocolo = $item['ordem'] ?? '';
                    $nomeformadotitulo = $item['nomenatureza'] ?? '';

                    // Montar texto do protocolo
                    $textoProtocolo = $protocolo;

                    $detalhes = [];
                    if (!empty($nomeformadotitulo)) {
                        $detalhes[] = $nomeformadotitulo;
                    }

                    if (!empty($detalhes)) {
                        $textoProtocolo .= " (" . implode(', ', $detalhes) . ")";
                    }

                    $protocolos[] = $textoProtocolo;
                }
            }

            if (!empty($protocolos)) {
                $texto = count($protocolos) > 1
                    ? "Existem protocolos em andamento sob nºs: "
                    : "Existe protocolo em andamento sob nº: ";
                $texto .= implode('; ', $protocolos);

                // Log para debug
                Log::info('Texto de contraditório gerado', ['texto' => $texto]);
                return $texto;
            }
        }

        return '';
    }

    public static function qrCode(string $conteudo): string
    {
        $code = new QrCode($conteudo);
        $png = (new Png())->output($code, config(150, 150));
        return "data:image/png;base64, " . base64_encode($png);
    }

    private static function adicionarLinhaDiagonalSeguranca(\Imagick $canvas, int $larguraA4, int $alturaA4, int $posYConteudo, int $larguraConteudo): void
    {
        try {
            // ✅ MESMA LÓGICA QUE FUNCIONOU ANTES
            $fimConteudoReal = $posYConteudo + 1350;
            $inicioLinhaHorizontal = $alturaA4 - 220;

            if (($inicioLinhaHorizontal - $fimConteudoReal) > 60) {
                // ✅ LINHA MENOR E MAIS DEITADA
                $margemLateral = 600; // Linha mais curta
                $startX = $margemLateral;
                $endX = $larguraA4 - $margemLateral;

                // ✅ LINHA MAIS DEITADA - menor diferença vertical
                $meioY = ($fimConteudoReal + $inicioLinhaHorizontal) / 2;
                $startY = $meioY - 25; // Só 50px de diferença total
                $endY = $meioY + 25;   // Linha bem deitada

                Log::info('Linha menor e deitada', [
                    'startX' => $startX,
                    'startY' => $startY,
                    'endX' => $endX,
                    'endY' => $endY,
                    'comprimento' => ($endX - $startX),
                    'inclinacao' => ($endY - $startY)
                ]);

                $desenho = new \ImagickDraw();
                $corPreta = new \ImagickPixel('#000000');

                $desenho->setStrokeColor($corPreta);
                $desenho->setStrokeWidth(2);

                // ✅ LINHA DIAGONAL DEITADA
                $desenho->line($startX, $startY, $endX, $endY);

                $canvas->drawImage($desenho);

                Log::info('Linha diagonal deitada desenhada com sucesso');

                $desenho->clear();
                $desenho->destroy();
                $corPreta->clear();
                $corPreta->destroy();
            } else {
                Log::info('Espaço insuficiente para linha');
            }
        } catch (Exception $e) {
            Log::error('Erro: ' . $e->getMessage());
        }
    }
}
