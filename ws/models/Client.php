
<?php

require_once 'BaseModel.php';

class Client extends BaseModel {
    public function __construct() {
        parent::__construct('EF_clients');
    }
    public function login($numeroClient, $motDePasse)
    {
        $sql = "SELECT * FROM clients WHERE numero_client = ?";
        $res = $this->rawFetch($sql, [$numeroClient]);
        if($res["mot_de_passe"] == $motDePasse) 
        {
            return $res;
        }

        return null;
    }
}
