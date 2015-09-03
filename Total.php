<?php 

class Total {

	/**
	 * Valor total de um pedido
	 * @var float $total
	 */
    protected $total;

    /**
     * @param float $total - Valor total do pedido
     */
    function __construct($total){
    	$this->setTotal($total);
    }

    /**
     * Armazena o valor total do pedido
     * @param float $total
     */
    protected function setTotal($total){

		if(preg_match("/[.,]/", $total) !== 0){
			$total = substr_replace(preg_replace("/[^0-9]/", "", $total), ".", -2, 0);
		} else {
			$total .= ".00";
		}

		if($total > 0){
			$this->total = $total;
		} else {
			throw new Exception("O total do pedido deve ser maior que R$ 0,00.");
		}

    }

    /**
     * @return float
     */
    public function getTotal(){
    	return $this->total;
    }

}
