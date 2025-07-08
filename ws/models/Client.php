<?php

require_once 'BaseModel.php';

class Client extends BaseModel
{
    public function __construct()
    {
        parent::__construct('EF_clients');
    }

    public function login($numeroClient, $motDePasse)
    {
        $sql = "SELECT * FROM EF_clients WHERE numero_client = ?";
        $res = $this->rawFetch($sql, [$numeroClient]);
        if ($res && count($res) > 0 && $motDePasse == $res[0]['mot_de_passe']) {
            return $res[0];
        }
        return null;
    }

    public function filterClient($nom, $email, $numero)
    {
        $sql = "SELECT * FROM EF_clients WHERE 1=1";
        $params = [];

        if (!empty($nom)) {
            $sql .= " AND nom LIKE ?";
            $params[] = '%' . $nom . '%';
        }
        if (!empty($email)) {
            $sql .= " AND email LIKE ?";
            $params[] = '%' . $email . '%';
        }
        if (!empty($numero)) {
            $sql .= " AND numero_client LIKE ?";
            $params[] = '%' . $numero . '%';
        }

        return $this->rawFetch($sql, $params);
    }
}
