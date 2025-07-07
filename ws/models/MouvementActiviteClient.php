<?php

require_once 'BaseModel.php';

class MouvementActiviteClient extends BaseModel {
    public function __construct() {
        parent::__construct('EF_mouvement_activite_client');
    }
}