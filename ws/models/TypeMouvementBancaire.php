<?php

require_once 'BaseModel.php';

class TypeMouvementBancaire extends BaseModel {
    public function __construct() {
        parent::__construct('EF_types_mouvements_bancaires');
    }
}