<?php 

require_once("Array2XML.php");
require_once("Cartao.php");
require_once("ConfirmTxn.php");
require_once("ConfPreAuthorization.php");
require_once("CouncilReport.php");
require_once("CouncilReportResponse.php");
require_once("Data.php");
require_once("GetAuthorized.php");
require_once("GetAuthorizedAVS.php");
require_once("Numero.php");
require_once("Pedido.php");
require_once("Response.php");
require_once("SalesSumm.php");
require_once("SalesSummResponse.php");
require_once("Total.php");
require_once("Usuario.php");
require_once("VoidConfPreAuthorization.php");
require_once("VoidPreAuthorization.php");
require_once("VoidTransaction.php");
require_once("XML2Array.php");

class Komerci extends SoapClient {

    const WSDL_URL = 'https://ecommerce.redecard.com.br/pos_virtual/wskomerci/cap.asmx?WSDL';
    const WSDL_TEST_URL = 'https://ecommerce.redecard.com.br/pos_virtual/wskomerci/cap_teste.asmx?WSDL';

    /**
     * Ambiente de teste ou de desenvolvimento
     * @var bool $teste
     */
    private $teste = true;

    /**
     * Qual o método do Webservice que será solicitado
     * @var string $metodo
     */
    private $metodo;

    /**
     * Parâmetros que serão passados para o webservice
     * @var array $parametros
     */
    private $parametros;

    /**
     * Resposta/retorno do Webservice Komerci
     * @var Response $resposta
     */
    private $resposta;

    /**
     * Número de filiação da loja com a Rede
     * @var string $filiacao
     */
    protected $filiacao = '037916785';

    /**
     * Prepara todos os parâmetros que serão enviados para o Webservice Komerci
     * @return Response
     */
    public function enviar(){

        $this->metodo = get_class($this);

        //Se a transação for realizada em ambiente de teste, o sufixo "Tst" deve ser passado no método
        if($this->teste){
            $this->metodo .= "Tst";
        }
        
        $this->parametros[$this->metodo]['Filiacao'] = $this->filiacao;
        
        if(method_exists($this, 'getUsuario')){
            $this->parametros[$this->metodo]['Usr'] = $this->getUsuario()->getUsr();
            $this->parametros[$this->metodo]['Pwd'] = $this->getUsuario()->getPwd();
        }

        if(method_exists($this, 'getTotal')){
            $this->parametros[$this->metodo]['Total'] = $this->getTotal()->getTotal();
        }

        if(method_exists($this, 'getPedido')){
            if(method_exists($this, 'getData')){
                $this->parametros[$this->metodo]['TransOrig'] = $this->getPedido()->getTransacao();
            } else {
                $this->parametros[$this->metodo]['Transacao'] = $this->getPedido()->getTransacao();
            }
            $this->parametros[$this->metodo]['Parcelas'] = $this->getPedido()->getParcelas();
            $this->parametros[$this->metodo]['NumPedido'] = $this->getPedido()->getNumPedido();
        } 

        if(method_exists($this, 'getCartao')){
            $this->parametros[$this->metodo]['Nrcartao'] = $this->getCartao()->getNrCartao();
            $this->parametros[$this->metodo]['CVC2'] = $this->getCartao()->getCvc2();
            $this->parametros[$this->metodo]['Mes'] = $this->getCartao()->getMes();
            $this->parametros[$this->metodo]['Ano'] = $this->getCartao()->getAno();
            $this->parametros[$this->metodo]['Portador'] = $this->getCartao()->getPortador();
        }

        if(method_exists($this, 'getCpf')){
            $this->parametros[$this->metodo]['CPF']         = $this->getCpf();
            $this->parametros[$this->metodo]['Endereco']    = $this->getEndereco();
            $this->parametros[$this->metodo]['Num1']        = $this->getNum1();
            $this->parametros[$this->metodo]['Complemento'] = $this->getComplemento();
            $this->parametros[$this->metodo]['Cep1']        = $this->getCep1();
            $this->parametros[$this->metodo]['Cep2']        = $this->getCep2();
        }

        if(method_exists($this, 'getData_inicial')){
            $this->parametros[$this->metodo]['Data_Inicial'] = $this->getData_inicial()->getData();
            $this->parametros[$this->metodo]['Data_Final'] = $this->getData_final()->getData();
        }

        if(method_exists($this, 'getTipo_trx')){
            $this->parametros[$this->metodo]['Tipo_Trx'] = $this->getTipo_trx();
        }

        if(method_exists($this, 'getStatus_trx')){
            $this->parametros[$this->metodo]['Status_Trx'] = $this->getStatus_trx();
        }

        if(method_exists($this, 'getServico_avs')){
            $this->parametros[$this->metodo]['Servico_AVS'] = $this->getServico_avs();
        }

        if(method_exists($this, 'getParcelas')){
            $this->parametros[$this->metodo]['Parcelas'] = $this->getParcelas();
        }

        if(method_exists($this, 'getData')){
            $this->parametros[$this->metodo]['Data'] = $this->getData()->getData();
        }

        if(method_exists($this, 'getNumero')){
            $this->parametros[$this->metodo]['NumAutor'] = $this->getNumero()->getNumAutor();
            $this->parametros[$this->metodo]['NumCV'] = $this->getNumero()->getNumCv();
            if($this->getNumero()->getNumSqn()){
                $this->parametros[$this->metodo]['NumSqn'] = $this->getNumero()->getNumSqn();
            }
        }

        if(method_exists($this, 'getConfTxn')){
            $this->parametros[$this->metodo]['ConfTxn'] = $this->getConfTxn();
        }

        if(isset($this->distribuidor)){
            $this->parametros[$this->metodo]['Distribuidor'] = $this->distribuidor;
        }

        if(isset($this->concentrador)){
            $this->parametros[$this->metodo]['Concentrador'] = $this->concentrador;
        }

        if(isset($this->iata)){
            $this->parametros[$this->metodo]['IATA'] = $this->iata;
            $this->parametros[$this->metodo]['TaxaEmbarque'] = $this->taxaembarque;
            $this->parametros[$this->metodo]['Entrada'] = $this->entrada;
            $this->parametros[$this->metodo]['Add_Data'] = $this->add_data;
        } 

        if(isset($this->numDoc1)){
            $this->parametros[$this->metodo]['NumDoc1'] = $this->numDoc1;
            $this->parametros[$this->metodo]['NumDoc2'] = $this->numDoc2;
            $this->parametros[$this->metodo]['NumDoc3'] = $this->numDoc3;
            $this->parametros[$this->metodo]['NumDoc4'] = $this->numDoc4;
            $this->parametros[$this->metodo]['Pax1'] = $this->pax1;
            $this->parametros[$this->metodo]['Pax2'] = $this->pax2;
            $this->parametros[$this->metodo]['Pax3'] = $this->pax3;
            $this->parametros[$this->metodo]['Pax4'] = $this->pax4;
        }

        $this->SoapRequest(); 

        return $this->resposta;

    }

    /**
     * Envia os dados para o Webservice
     */
    private function SoapRequest() {

        $webServiceUrl = ($this->teste) ? Komerci::WSDL_TEST_URL : Komerci::WSDL_URL;
        
        $soapClient = new SoapClient($webServiceUrl, $this->parametros); 
        $soapResult = $soapClient->__soapCall($this->metodo, $this->parametros);

        $resultado = $this->metodo."Result";
        
        $this->resposta = new Response($soapResult->$resultado->any);

    }

}
