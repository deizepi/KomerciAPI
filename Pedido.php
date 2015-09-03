<?php 

class Pedido {

    const A_VISTA = '04';
    const PARCELADO_EMISSOR = '06';
    const PARCELADO_ESTABELECIMENTO = '08';
    const IATA_A_VISTA = '39';
    const IATA_PARCELADO = '40';
    const PRE_AUTHORIZATION = '73';

    /**
     * Número do pedido
     * @var string $numPedido
     */
    protected $numPedido;

    /**
     * Forma de pagamento
     * @var string $transacao
     */
    protected $transacao;

    /**
     * Quantidade de parcelas em que o pagamento será feito
     * @var integer $parcelas
     */
    protected $parcelas;

    /**
     * @param string $numPedido - Número do pedido
     * @param string $transacao - Forma de pagamento
     * @param string $parcelas - Número de parcelas
     */
    function __construct($numPedido, $transacao, $parcelas){
    	$this->setNumPedido($numPedido);
    	$this->setTransacao($transacao);
    	$this->setParcelas($parcelas);
    }

    /**
     * Armazena o número de pedido da loja
     * @param string $pedido
     */
    protected function setNumPedido($pedido){
    	if(preg_match("/[^0-9a-zA-Z]/", $pedido) !== 0){
    		throw new Exception("O número do pedido deve ser composto apenas por números e letras.");
    	}
    	if(strlen($pedido) < 1){
    		throw new Exception("O número do pedido deve possuir ao menos 1 caracter.");
    	}
    	if(strlen($pedido) > 16){
    		throw new Exception("O número do pedido não pode ser maior que 16 caracteres.");
    	}
    	$this->numPedido = $pedido;
    }

    /**
     * Armazena o tipo de transação (forma de pagamento)
     * @param string $transacao
     */
    protected function setTransacao($transacao){
    	switch($transacao){
    		case Pedido::A_VISTA:
    		case Pedido::PARCELADO_EMISSOR:
    		case Pedido::PARCELADO_ESTABELECIMENTO:
    		case Pedido::IATA_A_VISTA:
    		case Pedido::IATA_PARCELADO:
    		case Pedido::PRE_AUTHORIZATION:
    			$this->transacao = $transacao;
    			break;
    		default:
    			throw new Exception("Forma de pagamento inválida.");
    	}
    }

    /**
     * Armazena o número de parcelas (caso o pagamento seja a vista, o número de parcelas deve ser zero)
     * @param integer $parcelas
     */
    protected function setParcelas($parcelas){
    	$parcelas = preg_replace("/[^0-9]/", "", $parcelas);
    	$a_vista  = array(Pedido::A_VISTA, Pedido::IATA_A_VISTA);
    	if(in_array($this->transacao, $a_vista)){
    		$this->parcelas = 0;
    	} else {
    		if($parcelas < 2){
    			throw new Exception("Número de parcelas inválido para a forma de pagamento escolhida.");
    		}
    		if($parcelas > 12){
    			throw new Exception("O número de parcelas não pode ser superior a 12.");
    		}
    		$this->parcelas = $parcelas;
    	}
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
    public function getTransacao(){
    	return $this->transacao;
    }

    /**
     * @return integer
     */
    public function getParcelas(){
    	return $this->parcelas;
    }
    
}
