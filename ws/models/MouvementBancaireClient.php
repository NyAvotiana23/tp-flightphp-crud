<?php

require_once 'BaseModel.php';

class MouvementBancaireClient extends BaseModel {
    public function __construct() {
        parent::__construct('EF_mouvements_bancaires_clients');
    }
}