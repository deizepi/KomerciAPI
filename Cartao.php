<?php 

class Cartao {

    /**
     * Número do cartão de crédito
     * @var string $nrCartao
     */
    protected $nrCartao;

    /**
     * Mes de validade de cartão
     * @var integer $mes
     */
    protected $mes;

    /**
     * Ano de validade do cartão
     * @var integer $ano
     */
    protected $ano;

    /**
     * CVC/código de segurança do cartão
     * @var integer $cvc2
     */
    protected $cvc2;

    /**
     * Nome impresso no cartão
     * @var string $portador
     */
    protected $portador;

    /**
     * @param string $nrCartao - Número do cartão
     * @param integer $mes - Mês de validade do cartão
     * @param integer $ano - Ano de validade do cartão
     * @param string $portador - Nome impresso no cartão
     */
    function __construct($nrCartao, $mes, $ano, $cvc2, $portador){
    	$this->setNrCartao($nrCartao);
    	$this->setMes($mes);
    	$this->setAno($ano);
    	$this->setCvc2($cvc2);
    	$this->setPortador($portador);
    }

    /**
     * Armazena o número do cartão, caso este seja válido
     * @param string $cartao
     */
    protected function setNrCartao($cartao){
    	$cartao = preg_replace("/[^0-9]/", "", $cartao);
    	if(strlen($cartao) < 13){
    		throw new Exception("O número do cartão deve possuir ao menos 13 caracteres.");
    	}
    	if(strlen($cartao) > 19){
    		throw new Exception("O número do cartão não pode ter mais de 19 caracteres.");
    	}
    	if(!$this->validarCartao($cartao)){
    		throw new Exception("Número do cartão inválido. Por favor, verifique os dados passados.");
    	}
    	$this->nrCartao = $cartao;
   	}

    /**
     * Valida o cartão, a partir da quantidade de dígitos e do algoritmo de Luhn
     * @param string $numero - Número do cartão a ser validado
     * @return bool - Retorno true caso o cartão seja válido, false caso contrário
     */
    private function validarCartao($numero){
        $numero = preg_replace("/[^0-9]/", "", $numero); //remove caracteres não numéricos
        if(strlen($numero) < 13 || strlen($numero) > 19)
            return false;
        $soma = '';
        foreach(array_reverse(str_split($numero)) as $i => $n){ 
            $soma .= ($i % 2) ? $n * 2 : $n; 
        }
        return array_sum(str_split($soma)) % 10 == 0;
    }

    /**
     * Armazena um mês válido para o vencimento do cartão
     * @param integer $mes
     */
    protected function setMes($mes){
    	$mes = preg_replace("/[^0-9]/", "", $mes);
    	if($mes < 1){
    		throw new Exception("O mês não pode ser menor que 1.");
    	}
    	if($mes > 12){
    		throw new Exception("O mês não pode ser maior que 12.");
    	}
    	$this->mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
    }

    /**
     * Armazena o ano de validade do cartão, verifica se o vencimento do cartão é válido
     * @param integer $ano
     */
    protected function setAno($ano){
    	$ano = preg_replace("/[^0-9]/", "", $ano);
    	$mes_atual = date("m");
    	$ano_atual = date("Y");
    	if($ano < $ano_atual){
    		throw new Exception("O ano de vencimento não pode ser menor que o ano atual.");
    	}
    	if($ano > ($ano_atual + 10)){
    		throw new Exception("O ano de vencimento não pode ser maior que ".($ano_atual + 10));
    	}
    	$venci = $ano.$this->mes;
    	$atual = $ano_atual.$mes_atual;
    	if($venci < $atual){
    		throw new Exception("O vencimento do cartão não pode ser inferior à data atual.");
    	}
    	$this->ano = substr($ano, 2);
    }

    /** 
     * Armazena o CVC/código de segurança do cartão
     * @param integer $cvc2
     */
    protected function setCvc2($cvc2){
    	$cvc2 = preg_replace("/[^0-9]/", "", $cvc2);
    	if(strlen($cvc2) < 3 || strlen($cvc2) > 3){
    		throw new Exception("O código de segurança do cartão deve possuir 3 caracteres.");
    	}
    	$this->cvc2 = $cvc2;
    }

    /**
     * Armazena o nome impresso no cartão
     * @param string $portador
     */
    protected function setPortador($portador){
    	$this->portador = $portador;
    }

    /**
     * @return string
     */
    public function getNrCartao(){
    	return $this->nrCartao;
    }

    /**
     * @return integer
     */
    public function getMes(){
    	return $this->mes;
    }

    /**
     * @return integer
     */
    public function getAno(){
    	return $this->ano;
    }

    /**
     * @return integer
     */
    public function getCvc2(){
    	return $this->cvc2;
    }

    /**
     * @return string
     */
    public function getPortador(){
    	return $this->portador;
    }

}
