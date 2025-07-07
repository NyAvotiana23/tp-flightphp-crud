
<?php

require_once 'BaseModel.php';

class Client extends BaseModel {
    public function __construct() {
        parent::__construct('EF_clients');
    }
}
