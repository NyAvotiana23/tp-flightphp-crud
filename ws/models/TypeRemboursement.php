<?php

require_once 'BaseModel.php';

class TypeRemboursement extends BaseModel {
    public function __construct() {
        parent::__construct('EF_types_remboursements');
    }
}
