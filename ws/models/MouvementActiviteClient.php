<?php

require_once 'BaseModel.php';

class MouvementActiviteClient extends BaseModel {
    public function __construct() {
        parent::__construct('mouvement_activite_client');
    }
}