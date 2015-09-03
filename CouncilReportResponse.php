<?php

class CouncilReportResponse {

    /**
     * Data de início do relatório
     * @var string $periodoInicio
     */
    private $periodoInicio;

    /**
     * Período final do relatório
     * @var string $periodoFim
     */
    private $periodoFim;

    /**
     * Data em que o relatório foi gerado
     * @var string $dataRequisicao
     */
    private $dataRequisicao;

    /**
     * Horário em que o relatório foi gerado
     * @var string $horaRequisicao
     */
    private $horaRequisicao;

    /**
     * Seu número de filiação
     * @var string $filiacao
     */
    private $filiacao;

    /**
     * Descrição do distribuidor, caso haja um
     * @var string $descricaoDistribuidor
     */ 
    private $descricaoDistribuidor;

    /**
     * Número de filiação do distribuidor, caso haja um
     * @var string $filiacaoDistribuidor
     */
    private $filiacaoDistribuidor;

    /**
     * Tipo de transacao
     * @var string $transacao
     */
    private $transacao;

    /**
     * Número de parcelas
     * @var integer $parcelas
     */
    private $parcelas;

    /**
     * Data da transação
     * @var string $data
     */
    private $data;

    /**
     * Hora da transação
     * @var string $hora
     */
    private $hora;

    /**
     * Total da transação
     * @var float $total
     */
    private $total;

    /**
     * Descrição da moeda (por exemplo, REAL)
     * @var string $moeda
     */
    private $moeda;

    /**
     * Número do pedido
     * @var string $numPedido
     */
    private $numPedido;

    /**
     * Número da autorização
     * @var string $numAutor
     */
    private $numAutor;

    /**
     * Número do comprovante de venda (NSU)
     * @var string $numCv
     */
    private $numCv;

    /**
     * Código de resultado
     * @var integer $codigo
     */
    private $codigo;

    /**
     * Mensagem de resultado
     * @var string $mensagem
     */
    private $mensagem;

    /**
     * Status da transação (textual, exemplo: Confirmada)
     * @var string $status
     */
    private $status;

    /**
     * Número do cartão truncado (seis primeiros dígitos e quatro último digitos)
     * @var string $numeroCartao
     */
    private $numeroCartao;

    /**
     * Nome impresso no cartão
     * @var string $nomePortador
     */
    private $nomePortador;

    /**
     * Data de expiração da pré autorização
     * @var string $dataExpiracao
     */
    private $dataExpiracao;

    /**
     * Data de conclusão da pré autorização
     * @var string $dataConclusao
     */
    private $dataConclusao;

    /**
     * Valor da taxa de embarque da transação
     * @var float $taxaEmbarque
     */
    private $taxaEmbarque;

    /**
     * Nome de usuário 
     * @var string $usuario
     */
    private $usuario;

    /**
     * CEP passado no serviço AVS
     * @var string $cep
     */
    private $cep;

    /** 
     * Número do endereço passado no serviço AVS
     * @var string $numeroEndereco
     */
    private $numeroEndereco;

    /**
     * Endereço passado no serviço AVS
     * @var string $endereco
     */
    private $endereco;

    /**
     * Quantidade de resultados
     * @var integer $quantidade
     */
    private $quantidade;
    
    /** 
     * @param array $retorno - XML de resposta do Komerci convertido em array
     */
    function __construct($retorno){
        if(isset($retorno['HEADER'])){
            $header = $retorno['HEADER'];
            $this->setPeriodo($header['PERIODO']);
            $this->dataRequisicao = Data::stringParaData($header['DATA_REQUISICAO']);
            $this->horaRequisicao = Data::stringParaHora($header['HORA_REQUISICAO']);
            $this->filiacao       = $header['FILIACAO'];
        }
        if(isset($retorno['REGISTRO'])){
            $registro = $retorno['REGISTRO'];
            $this->descricaoDistribuidor = $registro['DES_DSTR'];
            $this->filiacaoDistribuidor  = $registro['FILIACAO_DSTR'];
            $this->transacao      = $registro['TRANSACAO'];
            $this->parcelas       = $registro['PARCELAS'];
            $this->data           = Data::stringParaData($registro['DATA']);
            $this->hora           = Data::stringParaHora($registro['HORA']);
            $this->total          = $registro['TOTAL'];
            $this->moeda          = $registro['MOEDA'];
            $this->numPedido      = $registro['NUMPEDIDO'];
            $this->numAutor       = $registro['NUMAUTOR'];
            $this->numCv          = $registro['NUMCV'];
            $this->codigo         = $registro['COD_RET'];
            $this->mensagem       = $registro['MSG_RET'];
            $this->status         = $registro['STATUS'];
            $this->numeroCartao   = $registro['NR_CARTAO'];
            $this->nomePortador   = $registro['NOM_PORTADOR'];
            $this->dataExpiracao  = Data::stringParaData($registro['DATA_EXP_PRE_AUT']);
            $this->dataConclusao  = Data::stringParaData($registro['DATA_CON_PRE_AUT']);
            $this->taxaEmbarque   = $registro['TAXA_EMBARQUE'];
            $this->usuario        = $registro['USUARIO'];
            $this->cep            = $registro['CEP'];
            $this->numeroEndereco = $registro['NU_ENDERECO'];
            $this->endereco       = $registro['ENDERECO'];
        }
        if(isset($retorno['FOOTER'])){
            $footer = $retorno['FOOTER'];
            $this->quantidade = $footer['QTDE_TRX'];
        }
    }

    /**
     * Armazena os períodos de início e fim do relatório
     * @param array $periodo
     */
    private function setPeriodo($periodo){
        $periodo = explode("a", $periodo);
        $this->periodoInicio = Data::stringParaData($periodo[0]);
        $this->periodoFim    = Data::stringParaData($periodo[1]);
    }

    /**
     * @return string
     */
    public function getPeriodoInicio(){
        return $this->periodoInicio;
    }

    /**
     * @return string
     */
    public function getPeriodoFim(){
        return $this->periodoFim;
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
     * @return string
     */
    public function getDescricaoDistribuidor(){
        return $this->descricaoDistribuidor;
    }

    /**
     * @return string
     */
    public function getFiliacaoDistribuidor(){
        return $this->filiacaoDistribuidor;
    }

    /** 
     * @return string
     */
    public function getTransacao(){
        return $this->transacao;
    }

    /**
     * @return integer
     */
    public function getParcelas(){
        return $this->parcelas;
    }

    /**
     * @return string
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @return string
     */
    public function getHora(){
        return $this->hora;
    }

    /**
     * @return float
     */
    public function getTotal(){
        return $this->total;
    }

    /**
     * @return string
     */
    public function getMoeda(){
        return $this->moeda;
    }

    /**
     * @return string
     */
    public function getNumPedido(){
        return $this->numPedido;
    }

    /**
     * @return string
     */
    public function getNumAutor(){
        return $this->numAutor;
    }

    /**
     * @return string
     */
    public function getNumCv(){
        return $this->numCv;
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
    public function getStatus(){
        return $this->status;
    }

    /**
     * @return string
     */
    public function getNumeroCartao(){
        return $this->numeroCartao;
    }

    /**
     * @return string
     */
    public function getNomePortador(){
        return $this->nomePortador;
    }

    /**
     * @return string
     */
    public function getDataExpiracao(){
        return $this->dataExpiracao;
    }

    /**
     * @return string
     */
    public function getDataConclusao(){
        return $this->dataConclusao;
    }

    /**
     * @return float
     */
    public function getTaxaEmbarque(){
        return $this->taxaEmbarque;
    }

    /**
     * @return string
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * @return string
     */
    public function getCep(){
        return $this->cep;
    }

    /**
     * @return string
     */
    public function getNumeroEndereco(){
        return $this->numeroEndereco;
    }

    /**
     * @return string
     */
    public function getEndereco(){
        return $this->endereco;
    }

    /**
     * @return integer
     */
    public function getQuantidade(){
        return $this->quantidade;
    }

}
