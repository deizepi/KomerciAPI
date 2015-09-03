<?php 

class Data {

    /**
     * Data no formato aceita pelo Webservice Komerci AAAAMMDD
     * @var string $data
     */
    protected $data;

    /**
     * @param string $data - Data que será tratada
     */
    function __construct($data){
    	$this->setData($data);
    }

    /**
     * Função estática que converte o resultado de data do Komerci para a data no padrão americano AAAA-MM-DD
     * @param string $string - String numérica no formato AAAAMMDD
     */
    public static function stringParaData($string){
        $string = preg_replace("/[^0-9]/", "", $string);
        if(strlen($string) != 8){
            throw new Exception("Não foi possível identificar uma data válida em: $string.");
        }
        return substr_replace(substr_replace($string, "-", 4, 0), "-", 7, 0);
    }

    /**
     * Função estática que converte o resultado de horário do Komerci para o horário padrão universal HH:MM:SS
     * @param string $string - String numérica no formato HHMMSS
     */
    public static function stringParaHora($string){
        $string = preg_replace("/[^0-9]/", "", $string);
        if(strlen($string) != 6){
            throw new Exception("Não foi possível identificar um horário válido em: $string.");
        }
        return substr_replace(substr_replace($string, ":", 2, 0), ":", 5, 0);
    }

    /**
     * Armazena a data formatada para o Webservice Komerci
     * @param string $data - Recebe data nos padrões DD/MM/AAAA e AAAA-MM-DD
     */
    protected function setData($data){
    	if(strpos($data, "/") !== false){ // dd/mm/YYYY
    		$data = implode("", array_reverse(explode("/", $data)));
    	}
        if(strpos($data, "-") !== false){ // YYYY-mm-dd
    		$data = implode("", explode("-", $data));
    	}

    	$this->data = $data;
    }

    /**
     * @return string
     */
    public function getData(){
    	return $this->data;
    }

}
