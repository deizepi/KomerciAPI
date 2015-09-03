<?php 

/* Realiza a confirmação de transações de pré-autorização */
class ConfPreAuthorization extends Komerci {

    /**
     * Objeto Total
     * @var Total $total
     */
    protected $total;

    /**
     * Número de parcelas da transação
     * @var integer $parcelas
     */
    protected $parcelas;

    /**
     * Objeto Data
     * @var Data $data
     */
    protected $data;

    /**
     * Objeto Numero, contendo códigos de respostas da transação a ser confirmada
     * @var Numero $numero
     */
    protected $numero;

    /**
     * Objeto Usuario, com nome de usuário e senha cadastrados na ambiente da Rede
     * @var Usuario $usuario
     */
    protected $usuario;

    /**
     * Campos obrigatórios que devem ser passados com valores vazios
     * @var string $distribuidor
     * @var string $concentrador
     */
    public $distribuidor, $concentrador = '';

    /**
     * @var float $total - Total do pedido
     * @var integer $parcelas - Número de parcelas do pedido
     * @var string $data - Data em que foi realizada a pré-autorização
     * @var string $numAutor - Número de autorização da pré-autorização
     * @var string $numCv - Número do comprovante de venda (NSU) da pré-autorização
     */
    function __construct($total, $parcelas, $data, $numAutor, $numCv){
    	$this->total = new Total($total);
    	$this->setParcelas($parcelas);
    	$this->data = new Data($data);
    	$this->numero = new Numero($numAutor, $numCv);
        $this->usuario = new Usuario();
    }

    /**
     * Armazena a quantidade de parcelas
     * @param integer $parcelas
     */
    protected function setParcelas($parcelas){
    	$parcelas = preg_replace("/[^0-9]/", "", $parcelas);
    	if($parcelas < 0 || $parcelas > 12){
    		throw new Exception("O número de parcelas é obrigatório e não pode ser maior que 12.");
    	}
    	$this->parcelas = $parcelas;
    }

    /**
     * @return Total
     */
    public function getTotal(){
    	return $this->total;
    }

    /**
     * @return integer
     */
    public function getParcelas(){
    	return $this->parcelas;
    }

    /**
     * @return Data
     */
    public function getData(){
    	return $this->data;
    }

    /**
     * @return Numero
     */
    public function getNumero(){
    	return $this->numero;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

}
