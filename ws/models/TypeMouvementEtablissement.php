<?php
require_once 'BaseModel.php';

class TypeMouvementEtablissement extends BaseModel {
    public function __construct() {
        parent::__construct('EF_types_mouvements_etablissements');
    }
}