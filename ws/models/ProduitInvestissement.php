<?php 

require_once 'BaseModel.php';

class ProduitInvestissement extends BaseModel {
    public function __construct() {
        parent::__construct('produits_investissements');
    }
}