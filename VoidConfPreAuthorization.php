<?php 

/* Realiza o estorno de confirmação de transações de pré-autorização */
class VoidConfPreAuthorization extends Komerci {

    /**
     * Objeto Total, contendo o valor total do pedido
     * @var Total $total
     */
    protected $total;

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
     * Campo obrigatório que devem ser passado com valor vazio
     * @var string $concentrador
     */
    public $concentrador = '';

    /**
     * @param float $total - Total do valor a ser estornado
     * @param string $data - Data da transação
     * @param string $numAutor - Número de autorização da transação
     * @param string $numCv - Número do comprovante de venda da transação
     */
    function __construct($total, $data, $numAutor, $numCv){
    	$this->total = new Total($total);
    	$this->data = new Data($data);
    	$this->numero = new Numero($numAutor, $numCv);
        $this->usuario = new Usuario();
    }

    /**
     * @return Total
     */
    public function getTotal(){
    	return $this->total;
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
