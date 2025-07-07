<?php
require_once 'BaseModel.php';

class MouvementBancaireEtablissement extends BaseModel {
    public function __construct() {
        parent::__construct('mouvements_bancaires_etablissements');
    }
}
