<?php

/**
 * @todo Essa API foi desenvolvida em ambiente de teste (óbvio), justamente por isso não é possível
 * prever todos os retornos possíveis, bem como o formato de vários resultados. Posteriormente, esse atributos
 * devem se tornar arrays.
 */
class SalesSummResponse {

    /**
     * Data em que foi realizada a consulta
     * @var string $dataRequisicao
     */
    private $dataRequisicao;

    /**
     * Horário em que a consulta foi realizada
     * @var string $horaRequisicao
     */
    private $horaRequisicao;

    /**
     * Número de filiação entre a loja e a Rede
     * @var string $filiacao
     */
    private $filiacao;

    /**
     * Código de retorno
     * @var integer $codigo
     */
    private $codigo;

    /**
     * Mensagem de retorno
     * @var string $mensagem
     */
    private $mensagem;

    /**
     * Data de geração do resumo de vendas
     * @var string $dataResumo (formato: DD/MM/AAAA)
     */
    private $dataResumo;

    /**
     * Quantidade de vendas no período
     * @var integer $qtdVendas
     */
    private $qtdVendas;

    /**
     * Valor total das vendas
     * @var float $valorTotal
     */
    private $valorTotal;

    /**
     * Valor líquido das vendas
     * @var float $valorLiquido
     */
    private $valorLiquido;

    //Os valores abaixo são retornados pelo Webservice, mas não são mencionados na documentação oficial
    //private $row_count;
    //private $nu_rv;
    //private $text;
    
    /**
     * @param array $retorno - XML de resposta convertido em array
     */
    function __construct($retorno){
        if(isset($retorno['root'])){
            $root = $retorno['root'];
            $this->codigo = $root['codret'];
            $this->mensagem = $root['msgret'];

            if($this->getCodigo() != 0){
                throw new Exception($this->getMensagem());
            }
            
            $this->row_count = $root['resumoVendas']['@attributes']['row_count'];
            $resumo = $root['resumoVendas']['rv'];
            $atributos = $resumo['@attributes'];

            $this->dataResumo   = $atributos['dt_rv'];
            $this->qtdVendas    = $atributos['qtd_cv'];
            $this->valorTotal   = $atributos['val_totl_pago'];
            $this->valorLiquido = $atributos['val_totl_lqdo'];
            //$this->nu_rv        = $atributos['nu_rv'];
            //$this->text         = $atributos['text'];
        }
        if(isset($retorno['HEADER'])){
            $header = $retorno['HEADER'];
            $this->dataRequisicao = Data::stringParaData($header['DATA_REQUISICAO']);
            $this->horaRequisicao = Data::stringParaHora($header['HORA_REQUISICAO']);
            $this->filiacao = $header['FILIACAO'];
        }
    }

    /**
     * @return string
     */
    public function getDataRequisicao(){
        return $this->dataRequisicao;
    }

    /**
     * @return string
     */
    public function getHoraRequisicao(){
        return $this->horaRequisicao;
    }

    /**
     * @return string
     */
    public function getFiliacao(){
        return $this->filiacao;
    }

    /**
     * @return integer
     */
    public function getCodigo(){
        return $this->codigo;
    }

    /**
     * @return string
     */
    public function getMensagem(){
        return $this->mensagem;
    }

    /**
     * @return string
     */
    public function getDataResumo(){
        return $this->dataResumo;
    }

    /**
     * @return integer
     */
    public function getQtdVendas(){
        return $this->qtdVendas;
    }

    /**
     * @return float
     */
    public function getValorTotal(){
        return $this->valorTotal;
    }

    /**
     * @return float
     */
    public function getValorLiquido(){
        return $this->valorLiquidor;
    }

}
