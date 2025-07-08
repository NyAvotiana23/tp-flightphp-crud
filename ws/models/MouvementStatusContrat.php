<?php

require_once 'BaseModel.php';

class MouvementStatusContrat extends BaseModel {
    public function __construct() {
        parent::__construct('EF_mouvement_status_contrat');
    }
}