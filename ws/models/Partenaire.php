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
                p.id as id,
            tp.designation as type_partenaire,
            p.nom_partenaire,
            p.description_partenaire,
            p.commentaire,
            mp.depot_maximum as depot_maximum,
            mp.depot_minimum as depot_minimum,
            mp.taux_rendement_annuel as taux_annuel
            FROM EF_partenaire p JOIN
            EF_type_partenaire tp ON p.id_type_partenaire = tp.id
            JOIN ef_mouvements_partenaire mp ON p.id = mp.id_partenaire
        ";

        return $this->rawFetch($sql, []);
    }
}
