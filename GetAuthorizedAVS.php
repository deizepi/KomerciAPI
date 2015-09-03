<?php 

/* Realiza a autorização da transação de crédito */
class GetAuthorizedAVS extends GetAuthorized {

    /**
     * CPF do portador do cartão
     * @var string $cpf
     */
    protected $cpf;

    /**
     * Endereço do portador do cartão
     * @var string $endereco
     */
    protected $endereco;

    /**
     * Número do endereço do portador do cartão
     * @var string $num1
     */
    protected $num1;

    /**
     * Complemento do endereço do portador do cartão
     * @var string $complemento
     */
    protected $complemento;

    /**
     * CEP do endereço do portador
     * @var string $cep1
     */
    protected $cep1;

    /**
     * CEP do endereço do portador
     * @var string $cep2
     */
    protected $cep2 = '';

    /**
     * Utiliza o AVS (Address Verification Service) para tornar a transação mais segura
     * @param string $cpf - CPF do portador do cartão
     * @param string $cep1 - CEP do endereço do portador do cartão
     * @param string $endereco - Endereço do portador do cartão
     * @param string $num - Número do endereço do portador do cartão
     * @param string $complemento - Complemento do endereço do portador do cartão
     */
    public function setAVS($cpf, $cep1, $endereco, $num, $complemento = ''){
        $this->setCpf($cpf);
        $this->setCep($cep1);
        $this->setEndereco($endereco);
        $this->setNum($num);
        $this->setComplemento($complemento);
    }

    /**
     * Armazena um CPF válido
     * @param string $cpf
     */
    private function setCpf($cpf){
        if(!$this->validarCpf($cpf)){
            throw new Exception("CPF inválido.");
        }
        $this->cpf = $cpf;
    }

    /**
     * Faz a validação do CPF
     * @param string $cpf
     * @return bool
     */
    private function validarCpf($cpf){
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

        if (strlen($cpf) != 11)
            return false;

        $invalidos = array(00000000000, 11111111111, 22222222222, 33333333333, 44444444444, 55555555555, 66666666666, 77777777777, 88888888888, 99999999999);
        if(in_array($cpf, $invalidos))
            return false;

        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;

        $resto = $soma % 11;

        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;

        $resto = $soma % 11;

        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * Armazena o CEP do endereço (se o CEP1 existir, armazenará o valor em CEP2)
     * @param string $cep
     */
    public function setCep($cep){
        $cep = preg_replace('/[^0-9]/', '', $cep);
        if(strlen($cep) != 8){
            throw new Exception("O CEP precisa ter 8 caracteres numéricos.");
        }

        if(!isset($this->cep1)){
            $this->cep1 = $cep;
        } else {
            $this->cep2 = $cep;
        }
    }

    /**
     * Armazena o endereço do portador do cartão
     * @param string $endereco
     */
    private function setEndereco($endereco){
        $this->endereco = $endereco;
    }

    /**
     * Armazena o número do endereço do portador 
     * @param string $num
     */
    private function setNum($num){
        $this->num1 = $num;
    }

    /**
     * Armazena o complemento do endereço do portador
     * @param string $complemento
     */
    private function setComplemento($complemento){
        $this->complemento = $complemento;
    }

    /**
     * @return string
     */
    public function getCpf(){
        return $this->cpf;
    }

    /**
     * @return string
     */
    public function getEndereco(){
        return $this->endereco;
    }

    /**
     * @return string
     */
    public function getNum1(){
        return $this->num1;
    }

    /**
     * @return string
     */
    public function getComplemento(){
        return $this->complemento;
    }

    /**
     * @return string
     */
    public function getCep1(){
        return $this->cep1;
    }

    /**
     * @return string
     */
    public function getCep2(){
        return $this->cep2;
    }

}
