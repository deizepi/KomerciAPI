<?php 

class Numero {

    /**
     * Número do Comprovante de Venda (NSU) - 9 caracteres
     * @var string $numCv
     */
    protected $numCv;

    /**
     * Número de Autorização - 6 caracteres
     * @var string $numAutor
     */
    protected $numAutor;

    /**
     * Número sequencial único - 12 caracteres
     * @var string $numSqn
     */
    protected $numSqn;
    
    /**
     * @param string $numAutor - Número de autorização
     * @param string $numCv - Número do comprovante de venda
     * @param string $numSqn - Número sequencial único
     */
    function __construct($numAutor, $numCv, $numSqn = null){
        $this->setNumSqn($numSqn);
    	$this->setNumAutor($numAutor);
    	$this->setNumCv($numCv);
    }

    /**
     * Armazena o número de autorização
     * @var string $numAutor
     */
    protected function setNumAutor($numAutor){
    	$numAutor = preg_replace("/[^a-zA-Z0-9]/", "", $numAutor);
    	if(strlen($numAutor) < 1 || strlen($numAutor) > 6){
    		throw new Exception("O número da autorização deve ter entre 1 e 6 caracteres.");
    	}
    	$this->numAutor = $numAutor;
    }

    /**
     * Armazena o número de comprovante de venda
     * @var string $numCv
     */
    protected function setNumCv($numCv){
    	$numCv = preg_replace("/[^0-9]/", "", $numCv);
    	if(strlen($numCv) < 1 || strlen($numCv) > 9){
    		throw new Exception("O número do comprovante de venda (NSU) é obrigatório e não pode ter mais de 9 caracteres.");
    	}
    	$this->numCv = $numCv;
    }

    /** 
     * Armazena o número sequencial unico
     * @var string $numSqn
     */
    protected function setNumSqn($numSqn){
        $this->numSqn = $numSqn;
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
     * @return string
     */
    public function getNumSqn(){
        return $this->numSqn;
    }

}
