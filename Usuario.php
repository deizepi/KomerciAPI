<?php 

class Usuario {

    /**
     * Usuário de acesso ao sistema Rede
     * @var string $usr
     */
    protected $usr = 'testews';

    /**
     * Senha de acesso ao sistema Rede
     * @var string $senha
     */
    protected $pwd = 'testews';

    function __construct(){

    }

    /**
     * @return string
     */
    public function getUsr(){
        return $this->usr;
    }

    /**
     * @return string
     */
    public function getPwd(){
        return $this->pwd;
    }

}
