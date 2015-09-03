<?php 

/* Realiza a captura/confirmação da transação */
class ConfirmTxn extends Komerci {

    /**
     * Todos os dados do pedido e informações de pagamento (Nº pedido, forma de pagamento, parcelas)
     * @var Pedido $pedido
     */
    protected $pedido;

    /**
     * Objeto Total
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
     * Campos obrigatórios que devem ser passados com valores vazios
     * @var string $distribuidor
     * @var string $numDoc1
     * @var string $numDoc2
     * @var string $numDoc3
     * @var string $numDoc4
     * @var string $pax1
     * @var string $pax2
     * @var string $pax3
     * @var string $pax4
     */
    public $distribuidor, $numDoc1, $numDoc2, $numDoc3, $numDoc4, $pax1, $pax2, $pax3, $pax4 = '';

    /**
     * @param string $numPedido - Número do pedido na loja
     * @param float $total - Total do pedido, com duas casas decimais separadas por '.' (ponto)
     * @param integer $parcelas - Número de parcelas do pagamento
     * @param string $transOrig - Forma de pagamento (origem da transação)
     * @param string $data - Data da transação a ser confirmada
     * @param string $numSqn - Número sequencial único da transação a ser confirmada
     * @param string $numAutor - Número de autorização da transação a ser confirmada
     * @param string $numCv - Número do Comprovante de Venda (NSU) da transação a ser confirmada
     */
    function __construct($numPedido, $total, $parcelas, $transOrig, $data, $numSqn, $numAutor, $numCv){
        $this->pedido = new Pedido($numPedido, $transOrig, $parcelas);
    	$this->total = new Total($total);
    	$this->data = new Data($data);
    	$this->numero = new Numero($numAutor, $numCv, $numSqn);
    }

    /**
     * @return Pedido
     */
    public function getPedido(){
        return $this->pedido;
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

}
