<?php 

require_once 'BaseModel.php';

class FondInvestiClient extends BaseModel {
    public function __construct() {
        parent::__construct('fonds_investis_clients');
    }
}