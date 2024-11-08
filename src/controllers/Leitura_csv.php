<?php

namespace src\controllers;

use Exception;
use src\models\Produto;

require __DIR__ . "/../models/Produto.php";

class Lercsv
{
    public function csv()
    {
        require __DIR__ . "/../../views/home.phtml";
    }

    public function teste()
    {
        try {
            $testeArquivo = $_FILES['file'];
            $Produto = new Produto();
            $this->lerCsv($testeArquivo, $Produto);

            echo json_encode(['mensagem' => $e->getMessage()]);
        } catch (\Exception $e) {
            echo json_encode(['erro' => $e->getMessage()]);
        }
    }

    public function lerCsv($arquivocsv, $classe)
    {
        try {
            if (!empty($arquivocsv) && $arquivocsv['error'] === 0) {
                $caminhoArquivo = $arquivocsv['tmp_name'];
                $arquivo = fopen($caminhoArquivo, 'r');

                $colunas = fgetcsv($arquivo);
                if ($colunas === false) {
                    throw new \Exception("Erro ao ler o cabeçalho do arquivo");
                }

                while (($data = fgetcsv($arquivo)) !== false) {
                    $Objeto = new $classe;

                    foreach ($colunas as $index => $colunaNome) {
                        if (isset($data[$index])) {
                            $valor = $data[$index];

                            if (is_numeric($valor)) {
                                $valor = strpos($valor, '.') ? (float)$valor : (int)$valor;
                            }

                            $Objeto->{$colunaNome} = $valor;
                        }
                    }

                    if (!$Objeto->save()) {
                        throw new \Exception("Erro ao salvar." . json_encode($Objeto->getMessages()));
                    } 
                }

                fclose($arquivo);
                throw new \Exception('Importação concluída com sucesso.');
            } else {
                throw new \Exception('Nenhum arquivo enviado.');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
