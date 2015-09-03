<?php 

/* Realizar a extração do resumo de vendas que contém um sumário das vendas efetuadas na data corrente */
class SalesSumm extends Komerci {

	/**
	 * Objeto com o usuário e senha para o Komerci
	 * @var Usuario $usuario
	 */
    protected $usuario;

    /**
     * Inicia o objeto com o usuário e senha padrão
     */
    function __construct(){
        $this->usuario = new Usuario();
    }

    /**
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

}
