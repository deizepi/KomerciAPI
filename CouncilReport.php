<?php 

/* Realiza a extração de relatório de transações */
class CouncilReport extends Komerci {

    const PENDENTE = 0;
    const CONFIRMADA = 1;
    const NAO_APROVADA = 2;
    const DESFEITA = 3;
    const ESTORNADA = 4;

    /**
     * Data inicial para o período em que o relatório será gerado
     * @var string $data_inicial
     */
    protected $data_inicial;

    /**
     * Data final para o período em que o relatório será gerado
     * @var string $data_final
     */
    protected $data_final;

    /**
     * Parâmetro facultativo, poderá conter o código do tipo de transação a ser pesquisado
     *      04 À vista
     *      06 Parcelado Emissor
     *      08 Parcelado Estabelecimento
     *      73 Pré-Autorização
     *      39 Crédito IATA (apenas para Companhias Aéreas)
     *      40 Parcelado Estabelecimento IATA (apenas para Companhias Aéreas)
     * @var string $tipo_trx
     */
    protected $tipo_trx;

    /**
     * Parâmetro facultativo, poderá conter o status de transação a ser pesquisado
     *      0 Pendente
     *      1 Confirmada
     *      2 Não Aprovada
     *      3 Desfeita
     *      4 Estornada
     */
    protected $status_trx;

    /**
     * Parâmetro facultativo, filtro para registros que utilizaram ou não AVS (Address Verification Service)
     *      S SIM
     *      N Não
     */
    protected $servico_avs;

    /**
     * Objeto Usuario, com nome de usuário e senha cadastrados na ambiente da Rede
     * @var Usuario $usuario
     */
    protected $usuario;

    /**
     * @param string $data_inicial - Data inicial do relatório
     * @param string $data_final - Data final do relatório
     * @param string $tipo_trx - Tipo de transação a ser pesquisada
     * @param integer $status_trx - Status da transação a ser pesquisada
     * @param string $servico_avs - Filtrar por AVS
     */
    function __construct($data_inicial, $data_final, $tipo_trx = null, $status_trx = null, $servico_avs = null){
        $this->data_inicial = new Data($data_inicial);
    	$this->data_final   = new Data($data_final);
        $this->setTipo_trx($tipo_trx);
        $this->setStatus_trx($status_trx);
        $this->setServico_avs($servico_avs);
        $this->usuario = new Usuario();
    }

    /**
     * Caso seja passado, armazena o tipo de transação que será filtrado no relatório
     * @param string $tipo_trx
     */
    protected function setTipo_trx($tipo_trx){
        if(isset($tipo_trx)){
            switch($tipo_trx){
                case Pedido::A_VISTA:
                case Pedido::PARCELADO_EMISSOR:
                case Pedido::PARCELADO_ESTABELECIMENTO:
                case Pedido::IATA_A_VISTA:
                case Pedido::IATA_PARCELADO:
                case Pedido::PRE_AUTHORIZATION:
                    $this->tipo_trx = $tipo_trx;
                    break;
                default:
                    throw new Exception("Filtro de pesquisa para o tipo de transação inválido.");
            }
        }
    }

    /**
     * Caso seja passado, armazena o status da transação a ser pesquisado
     * @param string $status_trx
     */
    protected function setStatus_trx($status_trx){
        if(isset($status_trx)){
            switch($status_trx){
                case CouncilReport::PENDENTE:
                case CouncilReport::CONFIRMADA:
                case CouncilReport::NAO_APROVADA:
                case CouncilReport::DESFEITA:
                case CouncilReport::ESTORNADA:
                    $this->status_trx = $status_trx;
                    break;
                default:
                    throw new Exception("Filtro de pesquisa para o status da transação inválido.");
            }
        }
    }

    /**
     * Caso seja passado, armazena se haverá ou não filtro AVS na pesquisa
     * @param string $servico_avs
     */
    protected function setServico_avs($servico_avs){
        if(isset($servico_avs)){
            $valido = array('S', 'N');
            if(!in_array($servico_avs, $valido)){
                throw new Exception("Filtro de pesquisa para o serviço AVS inválido.");
            }
            $this->servico_avs = $servico_avs;
        }
    }

    /**
     * @return string
     */
    public function getData_inicial(){
    	return $this->data_inicial;
    }

    /**
     * @return string
     */
    public function getData_final(){
        return $this->data_final;
    }

    /**
     * @return string
     */
    public function getTipo_trx(){
    	return $this->tipo_trx;
    }

    /**
     * @return string
     */
    public function getStatus_trx(){
        return $this->status_trx;
    }

    /**
     * @return string
     */
    public function getServico_avs(){
    	return $this->servico_avs;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

}
