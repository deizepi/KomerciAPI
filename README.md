# KomerciAPI
API para uso do Webservice da Rede e-commerce (Komerci)


Para usar a API basta baixar todos os arquivos e importar a classe "Komerci", feito isso é só instanciar a classe correspondente ao método do Webservice que deseja usar passando os parâmetros corretamente e verificar qual foi o retorno obtido.

** Não esqueça de ler o documento oficial da Rede **

[Manual Webservice Komerci](https://www.userede.com.br/Documents/Manuais/Manual_Komerci_WebService.pdf)

## GetAuhorized

    <?php
        require_once("Komerci.php");
      
        try {
      
          	$pedido 		= "1234567891";
          	$total 			= "0,01";
          	$transacao 		= "06";
          	$parcelas 		= "04";
          	$cartao 		= "5473620055044293";
          	$mes 			= "05";
          	$ano 			= "2017";
          	$cvc2 			= "178";
          	$portador 		= "MARCOS DA SILVA LIMA";
          
          	$a = new GetAuthorized($pedido, $total, $transacao, $parcelas, $cartao, $mes, $ano, $cvc2, $portador);
          	$a->setConfTxn("S");
          	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## GetAuthorizedAVS

    <?php
        require_once("Komerci.php");
      
        try {
          	
        	$pedido 		= "1234567891";
        	$total 			= "0,01";
        	$transacao 		= "06";
        	$parcelas 		= "04";
        	$cartao 		= "5473620055044293";
        	$mes 			= "05";
        	$ano 			= "2017";
        	$cvc2 			= "178";
        	$portador 		= "MARCOS DA SILVA LIMA";
    
        	$cpf = "435.619.354-78";
        	$cep = "06020-010";
        	$endereco = "Av dos Autonomistas";
        	$num = "1500";
        	
        	$a = new GetAuthorizedAVS($pedido, $total, $transacao, $parcelas, $cartao, $mes, $ano, $cvc2, $portador);
        	$a->setAVS($cpf, $cep, $endereco, $num);
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## 

    <?php
        require_once("Komerci.php");
      
        try {
          	
	        $transacao 		= "06";
        	$data_inicial 	= "01/08/2015";
        	$data_final 	= "20/08/2015";
        	
        	$a = new CouncilReport($data_inicial, $data_final, $transacao);
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## SalesSumm

    <?php
        require_once("Komerci.php");
      
        try {
          	
        	$a = new SalesSumm();
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## ConfirmTxn

    <?php
        require_once("Komerci.php");
      
        try {
          	
        	$pedido 		= "1234567891";
        	$total 			= "0,01";
        	$transacao 		= "06";
        	$parcelas 		= "04";
        	$cartao 		= "5473620055044293";
        	$mes 			= "05";
        	$ano 			= "2017";
        	$cvc2 			= "178";
        	$portador 		= "MARCOS DA SILVA LIMA";
        	
        	$a = new GetAuthorized($pedido, $total, $transacao, $parcelas, $cartao, $mes, $ano, $cvc2, $portador);
        
        	if($resultado){
        
        	    $numPedido 	= $resultado->getNumPedido();
        	    $data 		= $resultado->getData();
        	    $numAutor 	= $resultado->getNumAutor();
        	    $numCv 		= $resultado->getNumCv();
        	    $numSqn 	= $resultado->getNumSqn();
        
        		$t = new ConfirmTxn($numPedido, $total, $parcelas, $transacao, $data, $numSqn, $numAutor, $numCv);
        		$confirmacao = $t->enviar();
        		
        	}
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## ConfPreAuthorization

    <?php
        require_once("Komerci.php");
      
        try {
          	
        	$pedido 		= "1234567891";
        	$total 			= "0,01";
        	$transacao 		= "06";
        	$parcelas 		= "04";
        	$cartao 		= "5473620055044293";
        	$mes 			= "05";
        	$ano 			= "2017";
        	$cvc2 			= "178";
        	$portador 		= "MARCOS DA SILVA LIMA";
        	
        	$a = new GetAuthorized($pedido, $total, $transacao, $parcelas, $cartao, $mes, $ano, $cvc2, $portador);
        
        	if($resultado){
        
        	    $data 		= $resultado->getData();
        	    $numAutor 	= $resultado->getNumAutor();
        	    $numCv 		= $resultado->getNumCv();
        
		        $t = new ConfPreAuthorization($total, $parcelas, $data, $numAutor, $numCv);
        		$confirmacao = $t->enviar();
        		
        	}
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## VoidPreAuthorization

    <?php
        require_once("Komerci.php");
      
        try {
          	
        	$pedido 		= "1234567891";
        	$total 			= "0,01";
        	$transacao 		= "06";
        	$parcelas 		= "04";
        	$cartao 		= "5473620055044293";
        	$mes 			= "05";
        	$ano 			= "2017";
        	$cvc2 			= "178";
        	$portador 		= "MARCOS DA SILVA LIMA";
        	
        	$a = new GetAuthorized($pedido, $total, $transacao, $parcelas, $cartao, $mes, $ano, $cvc2, $portador);
        
        	if($resultado){
        
        	    $data 		= $resultado->getData();
        	    $numAutor 	= $resultado->getNumAutor();
        	    $numCv 		= $resultado->getNumCv();
        
		        $t = new VoidPreAuthorization($total, $data, $numAutor, $numCv);
        		$estorno = $t->enviar();
        		
        	}
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

## VoidTransaction

    <?php
        require_once("Komerci.php");
      
        try {
          	
        	$pedido 		= "1234567891";
        	$total 			= "0,01";
        	$transacao 		= "06";
        	$parcelas 		= "04";
        	$cartao 		= "5473620055044293";
        	$mes 			= "05";
        	$ano 			= "2017";
        	$cvc2 			= "178";
        	$portador 		= "MARCOS DA SILVA LIMA";
        	
        	$a = new GetAuthorized($pedido, $total, $transacao, $parcelas, $cartao, $mes, $ano, $cvc2, $portador);
        
        	if($resultado){
        
        	    $numAutor 	= $resultado->getNumAutor();
        	    $numCv 		= $resultado->getNumCv();
        
		        $t = new VoidTransaction($total, $numAutor, $numCv);
        		$estorno = $t->enviar();
        		
        	}
        	
  	    } catch(Exception  $erro){
	        echo $erro->getMessage();
  	    }

Após o cadastramento na Rede e homologação do Sistema, basta alterar o número de filiação e os dados de usuário para usar o sistema.

## Alterar o número de filiação

    //Na classe Komerci.php
    protected $filiacao = 'SEU NÚMERO DE FILIAÇÃO AQUI';
    
## Alterar os dados de usuário

    //Na classe Usuario.php
    protected $usr = 'SEU NOME DE USUÁRIO AQUI';
    protected $pwd = 'SUA SENHA SE ACESSO AQUI';
