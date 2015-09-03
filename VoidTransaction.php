<?php 

/* Realiza o estorno de transações de crédito */
class VoidTransaction extends Komerci {

    /**
     * Objeto Total, contendo o valor total do pedido
     * @var Total $total
     */
    protected $total;

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
     * @var string $distribuidor
     */
    public $concentrador = '';

    /**
     * @param float $total - Total do valor da transação
     * @param string $numAutor - Número de autorização da transação
     * @param string $numCv - Número do comprovante de venda da transação
     */
    function __construct($total, $numAutor, $numCv){
    	$this->total = new Total($total);
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
