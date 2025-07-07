<?php

require_once 'BaseModel.php';

class ContratPret extends BaseModel {
    public function __construct() {
        parent::__construct('contrats_prets');
    }
}