<?php
require_once __DIR__ . '/../models/FondInvestiClient.php';
require_once __DIR__ . '/../models/MouvementBancaireClient.php';
require_once __DIR__ . '/../models/MouvementBancaireEtablissement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class FondInvestiClientController {
    public static function getAll() {
        $model = new FondInvestiClient();
        $items = $model->findAllLoaded();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new FondInvestiClient();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function  create() {
        $model = new FondInvestiClient();
        $mouvementClientModel = new MouvementBancaireClient();
        $mouvementEtablissementModel = new MouvementBancaireEtablissement();
        $data = Flight::request()->data->getData();

        // Validate required fields
        if (!isset($data['id_partenaire']) || !isset($data['id_client']) || !isset($data['montant_investi']) || !isset($data['date_investissement'])) {
            Flight::json(['error' => 'Missing required fields'], 400);
            return;
        }

        try {
            // Start a transaction
            $model->db()->beginTransaction();

            // Create investment record
            $investmentId = $model->create([
                'id_partenaire' => $data['id_partenaire'],
                'id_client' => $data['id_client'],
                'montant_investi' => $data['montant_investi'],
                'date_investissement' => $data['date_investissement']
            ]);

            // Get type_mouvement_id for 'Fond investissement' (assuming it exists in EF_types_mouvements_bancaires)
            $typeMouvementClient = $model->rawFetch(
                "SELECT id FROM EF_types_mouvements_bancaires WHERE nom_type_mouvement = ?",
                ['Fond investissement']
            );
            if (empty($typeMouvementClient)) {
                throw new Exception("Type de mouvement 'Fond investissement' not found");
            }
            $typeMouvementClientId = $typeMouvementClient[0]['id'];

            // Create client movement (negative amount)
            $mouvementClientModel->create([
                'id_client' => $data['id_client'],
                'id_type_mouvement' => $typeMouvementClientId,
                'date_mouvement' => $data['date_investissement'],
                'montant' => -$data['montant_investi'] // Negative for client
            ]);



            // Get type_mouvement_id for 'Gain Fond' (assuming it exists in EF_types_mouvements_etablissements)
            $typeMouvementEtablissement = $model->rawFetch(
                "SELECT id FROM EF_types_mouvements_etablissements WHERE nom_type_mouvement = ?",
                ['Gain Fond']
            );
            if (empty($typeMouvementEtablissement)) {
                throw new Exception("Type de mouvement 'Gain Fond' not found");
            }
            $typeMouvementEtablissementId = $typeMouvementEtablissement[0]['id'];

            // Create etablissement movement (positive amount)
            $mouvementEtablissementModel->create([
                'id_etablissement' => 1,
                'id_type_mouvement' => $typeMouvementEtablissementId,
                'montant' => $data['montant_investi'], // Positive for etablissement
                'date_mouvement' => $data['date_investissement']
            ]);

            // Commit transaction
            $model->db()->commit();
            Flight::json(['id' => $investmentId, 'message' => 'Investment created successfully']);
        } catch (Exception $e) {
            $model->db()->rollBack();
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public static function update($id) {
        $model = new FondInvestiClient();
        $data = Flight::request()->data->getData();
        $model->update($id, $data);
        Flight::json(['message' => 'Fond investi client modifié']);
    }

    public static function delete($id) {
        $model = new FondInvestiClient();
        $model->delete($id);
        Flight::json(['message' => 'Fond investi client supprimé']);
    }
}