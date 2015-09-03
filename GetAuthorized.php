<?php 

/* Realiza a autorização da transação de crédito */
class GetAuthorized extends Komerci {

    /**
     * Objeto Pedido, contendo o número do pedido, o tipo de transação e o número do parcelas
     * @var Pedido $pedido
     */
    protected $pedido;

    /**
     * Objeto Total, contendo o valor total do pedido
     * @var Total $total
     */
    protected $total;

    /**
     * Objeto Cartao, contendo o número do cartão, validade (mês e ano), CVC (código de segurança) e o nome impresso
     * @var Cartao $cartao
     */
    protected $cartao;

    /**
     * Se a transação será confirmada automaticamente
     *      S Sim
     *      N Não
     * @var string $confTxn
     */
    protected $confTxn = 'S';

    /**
     * Campos obrigatórios que devem ser passados com valores vazios
     * @var string $iata
     * @var string $distribuidor
     * @var string $concentrador
     * @var string $taxaembarque
     * @var string $entrada
     * @var string $numDoc1
     * @var string $numDoc2
     * @var string $numDoc3
     * @var string $numDoc4
     * @var string $pax1
     * @var string $pax2
     * @var string $pax3
     * @var string $pax4
     * @var string $add_data
     */
    public $iata, $distribuidor, $concentrador, $taxaembarque, $entrada, $numDoc1, $numDoc2, $numDoc3, $numDoc4, $pax1, $pax2, $pax3, $pax4, $add_data = '';

    /**
     * @param string $numPedido - Número do pedido na loja
     * @param float $total - Valor total do pedido
     * @param string $transacao - Tipo de transação (forma de pagamento)
     * @param integer $parcelas - Número de parcelas
     * @param string $nrCartao - Número do cartão
     * @param integer $mes - Mês de validade do cartão
     * @param integer $ano - Ano de validade do cartão
     * @param integer $cvc2 - Código de segurança do cartão
     * @param string $portador - Nome impresso no cartão
     */
    function __construct($numPedido, $total, $transacao, $parcelas, $nrCartao, $mes, $ano, $cvc2, $portador){
    	$this->pedido = new Pedido($numPedido, $transacao, $parcelas);
    	$this->total = new Total($total);
    	$this->cartao = new Cartao($nrCartao, $mes, $ano, $cvc2, $portador);
    }

    /**
     * Troca o valor padrão da confirmação automática, assumirá 'N' para qualquer valor que não seja 'S'
     * @param string $confTxn
     */
    public function setConfTxn($confTxn){
        if($confTxn == 'S'){
            $this->confTxn = $confTxn;
        } else {
            $this->confTxn = 'N';
        }
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
     * @return Cartao
     */
    public function getCartao(){
    	return $this->cartao;
    }

    /**
     * @return string 
     */
    public function getConfTxn(){
        return $this->confTxn;
    }

}
