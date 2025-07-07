<?php
require_once 'BaseModel.php';

class Partenaire extends BaseModel {
    public function __construct() {
        parent::__construct('EF_partenaire');
    }

    public function findAllLoaded()
    {
        $sql = "
            SELECT
            tp.description as type_partenaire,
            p.nom_partenaire,
            p.description_partenaire,
            p.commentaire
            FROM EF_partenaire p JOIN
            EF_type_partenaire tp ON p.id_type_partenaire = tp.id
        ";

        return $this->rawFetch($sql, []);
    }
}
