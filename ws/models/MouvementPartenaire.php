<?php

require_once 'BaseModel.php';

class MouvementPartenaire extends BaseModel {
    public function __construct() {
        parent::__construct('EF_mouvements_partenaire');
    }
}