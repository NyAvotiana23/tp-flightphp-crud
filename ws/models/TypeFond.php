<?php 

require_once 'BaseModel.php';

class TypeFond extends BaseModel {
    public function __construct() {
        parent::__construct('EF_types_fonds');
    }
}
