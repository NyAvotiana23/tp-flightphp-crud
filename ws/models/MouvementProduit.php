<?php

require_once 'BaseModel.php';

class MouvementProduit extends BaseModel {
    public function __construct() {
        parent::__construct('mouvements_produits');
    }
}