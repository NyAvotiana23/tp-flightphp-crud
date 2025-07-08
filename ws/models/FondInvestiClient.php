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
            tp.description as type,
            cl.nom,
            ficl.montant_investi,
            ficl.date_investissement
            FROM
            EF_fonds_investis_clients ficl
            JOIN EF_partenaire p ON ficl.id_partenaire = p.id
            JOIN EF_clients cl ON cl.id = ficl.id_client
            JOIN EF_type_partenaire tp ON tp.id = p.id_type_partenaire
        ";

        return $this->rawFetch($sql, []);
    }
}