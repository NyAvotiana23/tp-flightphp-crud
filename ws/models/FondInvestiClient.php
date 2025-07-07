<?php 

require_once 'BaseModel.php';

class FondInvestiClient extends BaseModel {
    public function __construct() {
        parent::__construct('EF_fonds_investis_clients');
    }

    public function findAllLoaded()
    {
        $sql = " 
            SELECT 
            p.nom_partenaire,
            cl.nom,
            ficl.montant_investi,
            ficl.date_investissement,
            ficl.date_echeance_prevue,
            ficl.taux_rendement_applique,
            ficl.statut_investissement,
            ficl.montant_actuel
            FROM
            EF_fonds_investis_clients ficl
            JOIN EF_partenaire p ON ficl.id_partenaire = p.id
            JOIN EF_clients cl ON cl.id = ficl.id_client
        ";

        return $this->rawFetch($sql, []);
    }
}