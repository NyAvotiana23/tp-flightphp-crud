<?php
require_once 'BaseModel.php';

class EtablissementFinancier extends BaseModel {
    public function __construct() {
        parent::__construct('EF_etablissements_financiers');
    }
}

