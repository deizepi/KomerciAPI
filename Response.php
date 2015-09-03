<?php

class Response {

    /**
     * Código de resposta do Webservice
     * @var string $codigo
     */
    private $codigo;

    /**
     * Mensagem de resposta do Webservice
     * @var string $mensagem
     */
    private $mensagem;

    /**
     * Número do pedido passado no momento da transação
     * @var string $numPedido
     */
    private $numPedido;

    /**
     * Data da transação
     * @var string $data
     */
    private $data;

    /**
     * Número de autorização da transação
     * @var string $numAutor
     */
    private $numAutor;

    /**
     * Número do comprovante de venda da transação
     * @var string $numCv
     */
    private $numCv;

    /** 
     * Número da autenticação da transação
     * @var string $numAutent
     */
    private $numAutent;

    /**
     * Número de parcelas da transação
     * @var integer $parcelas
     */
    private $parcelas;

    /**
     * Número sequencial unico da transação
     * @var string $numSqn
     */
    private $numSqn;

    /**
     * Código do país do emissor (ex: BRA)
     * @var string $origem_bin
     */
    private $origem_bin;

    /**
     * Código de resposta da confirmação
     * @var integer $confCodigo
     */
    private $confCodigo;

    /**
     * Mensagem de resposta da confirmação
     * @var string $confMensagem
     */
    private $confMensagem;

    /**
     * Caso o método utilizado retorne um relatório (como CouncilReport ou SalesSumm), guardo um objeto
     * @var Object $relatorio
     */
    private $relatorio;

    /**
     * Resposta do XML convertido em array
     * @var array $array
     */
    private $array;
    
    /**
     * @param string $xml - XML de resposta do Webservice
     */
    function __construct($xml){
        $array = XML2Array::createArray($xml);
        foreach($array as $indice => $valor){
            $this->array = $valor;
            switch($indice){
                case 'AUTHORIZATION': //GetAuthorized
                    $this->retornoAutorizacao();
                    break;
                case 'CONFIRMATION': //vários casos
                    $this->retornoConfirmacao();
                    break;
                case 'COUNCIL': //CouncilReport
                    $this->retornoVendas();
                    break;
                case 'REPORT': //SalesSumm
                    $this->retornoRelatorio();
                    break;
                case 'ROOT': //Erro no CouncilReport ou SalesSumm
                    $this->retornoErro();
                    break;
                default:
                    throw new \UnexpectedValueException('Retorno inesperado.');
            }
        }

        unset($this->array); //o atributo não será mais utilizado

    }

    /**
     * Armazena os valores do resultado da transação (GetAuthorized)
     */
    private function retornoAutorizacao(){
        $this->setRetorno();
        $this->setData();
        $this->setNumPedido();
        $this->setTransacao();
        $this->setConfirmacao();
    }

    /**
     * Armazena os valores do resultado de alguma ação (confirmação, cancelamento, pré-autorização, etc)
     */
    private function retornoConfirmacao(){
        if(isset($this->array['root'])){
            $this->array = $this->array['root'];
        }
        $this->setRetorno();
    }

    /**
     * Armazena os valores do resultado do método CouncilReport
     */
    private function retornoVendas(){
        $this->relatorio = new CouncilReportResponse($this->array);
    }

    /**
     * Armazena os valores do resultado do método SalesSumm
     */
    private function retornoRelatorio(){
        $this->relatorio = new SalesSummResponse($this->array);
    }

    /**
     * Armazena o erro gerado na tentativa de gerar um dos relatórios
     */
    private function retornoErro(){
        $this->setRetorno();
    }

    /**
     * Armazena o código e mensagem de retorno da transação/consulta
     */
    private function setRetorno(){
        if(isset($this->array['CODRET'])){
            $this->codigo    = $this->array['CODRET'];
            $this->mensagem  = $this->array['MSGRET'];
        }
        if(isset($this->array['codret'])){
            $this->codigo    = $this->array['codret'];
            $this->mensagem  = $this->array['msgret'];
        }
        if($this->codigo != 0){ //Se houve erro
            throw new Exception($this->mensagem);
        }
    }

    /**
     * Armazena a data da transação no formato AAAA-MM-DD (o Webservice retorna AAAAMMDD)
     */
    private function setData(){
        if(isset($this->array['DATA'])){
            $data = $this->array['DATA'];
            $this->data = Data::stringParaData($data);
        }
    }

    /**
     * Armazena o número do pedido da transação
     */
    private function setNumPedido(){
        if(isset($this->array['NUMPEDIDO'])){
            $this->numPedido = $this->array['NUMPEDIDO'];
        }
    }

    /**
     * Armazena os dados retornados pelo Webservice da transação
     */
    private function setTransacao(){
        $this->numAutor     = $this->array['NUMAUTOR'];
        $this->numCv        = $this->array['NUMCV'];
        $this->numAutent    = $this->array['NUMAUTENT'];
        $this->numSqn       = $this->array['NUMSQN'];
        $this->origem_bin   = $this->array['ORIGEM_BIN'];
    }

    /**
     * Armazena os dados da confirmação/captura da transação
     */
    private function setConfirmacao(){
        if(isset($this->array['CONFCODRET'])){
            $this->confCodigo = $this->array['CONFCODRET'];
            $this->confMensagem = $this->array['CONFMSGRET'];
            if($this->confCodigo != 0){
                throw new Exception($this->confMensagem);
            }
        }
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
    public function getNumPedido(){
        return $this->numPedido;
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
    public function getNumAutor(){
        return $this->numAutor;
    }

    /**
     * @return string
     */
    public function getNumAutent(){
        return $this->numAutent;
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
    public function getParcelas(){
        return $this->parcelas;
    }

    /**
     * @return string
     */
    public function getNumSqn(){
        return $this->numSqn;
    }

    /**
     * @return string
     */
    public function getOrigem_bin(){
        return $this->origem_bin;
    }

    /**
     * @return integer
     */
    public function getConfCodigo(){
        return $this->confCodigo;
    }

    /**
     * @return string
     */
    public function getConfMensagem(){
        return $this->confMensagem;
    }

    /**
     * @return Object
     */
    public function getRelatorio(){
        return $this->relatorio;
    }

}
