<?php

require_once 'BaseModel.php';

class RemboursementPret extends BaseModel {
    public function __construct() {
        parent::__construct('remboursements_prets');
    }
}