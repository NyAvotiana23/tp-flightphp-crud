<?php
require_once __DIR__ . '/../models/ContratPret.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/TypePret.php';
require_once __DIR__ . '/../models/MouvementStatusContrat.php';
require_once __DIR__ . '/../models/PretClient.php';
require_once __DIR__ . '/../models/MouvementBancaireClient.php';
require_once __DIR__ . '/../models/MouvementBancaireEtablissement.php';
require_once __DIR__ . '/../models/RemboursementPret.php';
require_once __DIR__ . '/../models/TypeRemboursement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ContratPretController {
    public static function getAll() {
        $model = new ContratPret();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new ContratPret();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        error_log("tsisy dikany");
        $model = new ContratPret();
        $clientModel = new Client();
        $typePretModel = new TypePret();
        $data = Flight::request()->data->getData();

        // Validate client exists
        $client = $clientModel->getById($data['id_client']);
        if (!$client) {
            Flight::json(['error' => 'Client non trouvé'], 404);
            return;
        }

        // Validate interest rate against type_pret min/max
        $typePret = $typePretModel->getById($data['id_type_pret']);
        if (!$typePret) {
            Flight::json(['error' => 'Type de prêt non trouvé'], 404);
            return;
        }
        if ($data['taux_interet_annuel'] < $typePret['taux_interet_min_annuel'] || $data['taux_interet_annuel'] > $typePret['taux_interet_max_annuel']) {
            Flight::json(['error' => 'Taux d\'intérêt hors plage autorisée'], 400);
            return;
        }

        // Create contract
        $contractId = $model->create($data);

        // Add pending status
        $statusModel = new MouvementStatusContrat();
        $statusModel->create([
            'id_contrat_pret' => $contractId,
            'id_status_contrat' => 1, // Assuming 1 is "En attente"
            'date_mouvement' => date('Y-m-d')
        ]);

        Flight::json(['id' => $contractId]);
    }

    public static function update($id) {
        $model = new ContratPret();
        $data = Flight::request()->data->getData();
        $model->update($id, $data);
        Flight::json(['message' => 'Contrat modifié']);
    }

    public static function delete($id) {
        $model = new ContratPret();
        $model->delete($id);
        Flight::json(['message' => 'Contrat supprimé']);
    }

    public static function approve($id) {
        $model = new ContratPret();
        $pretClientModel = new PretClient();
        $mouvementClientModel = new MouvementBancaireClient();
        $mouvementEtablissementModel = new MouvementBancaireEtablissement();
        $remboursementPretModel = new RemboursementPret();
        $typeRemboursementModel = new TypeRemboursement();
        $statusModel = new MouvementStatusContrat();

        $data = Flight::request()->data->getData();
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d');
        $delaiRemboursement = isset($data['delai_remboursement']) ? (int)$data['delai_remboursement'] : 0;

        $contract = $model->getById($id);
        if (!$contract) {
            Flight::json(['error' => 'Contrat non trouvé'], 404);
            return;
        }

        $typeRemboursement = $typeRemboursementModel->getById($contract['id_type_remboursement']);
        if (!$typeRemboursement) {
            Flight::json(['error' => 'Type de remboursement non trouvé'], 404);
            return;
        }

        try {
            $model->db()->beginTransaction();

            $statusModel->create([
                'id_contrat_pret' => $id,
                'id_status_contrat' => 2, // Validé
                'date_mouvement' => $date
            ]);

            $nombrePeriodes = ($contract['duree_remboursement_mois'] / 12) * $typeRemboursement['repetition_annuelle'];
            $duePeriodiqueAvecInteret = $contract['montant_echeance'];
            $duePeriodiqueAssurance = ($contract['taux_assurance_annuel'] / $typeRemboursement['repetition_annuelle']) * $contract['montant_pret'];
            $montantFinalARembourser = $duePeriodiqueAvecInteret * $nombrePeriodes;

            $pretId = $pretClientModel->create([
                'id_contrat_pret' => $id,
                'montant_pret' => $contract['montant_pret'],
                'montant_total_a_rembourser' => $montantFinalARembourser,
                'nombre_periodes' => $nombrePeriodes,
                'montant_echeance_periodique' => $duePeriodiqueAvecInteret,
                'montant_assurance_periodique' => $duePeriodiqueAssurance,
                'date_debut_pret' => $date,
                'date_fin_prevue_pret' => date('Y-m-d', strtotime($date . ' + ' . $contract['duree_remboursement_mois'] . ' months'))
            ]);

            $mouvementClientModel->create([
                'id_client' => $contract['id_client'],
                'id_type_mouvement' => 1, // Prêt
                'montant' => $contract['montant_pret'],
                'date_mouvement' => $date
            ]);

            $mouvementEtablissementModel->create([
                'id_etablissement' => 1, // Default establishment
                'id_type_mouvement' => 1, // Sortie Prêt
                'montant' => -$contract['montant_pret'],
                'date_mouvement' => $date
            ]);

            $remainingCapital = $contract['montant_pret'];
            for ($i = 1; $i <= $nombrePeriodes; $i++) {
                $interest = $remainingCapital * ($contract['taux_interet_annuel'] / 100 / $typeRemboursement['repetition_annuelle']);
                $capitalRepaid = $duePeriodiqueAvecInteret - $interest;
                $newRemainingCapital = $remainingCapital - $capitalRepaid;
                $totalDue = $duePeriodiqueAvecInteret + $duePeriodiqueAssurance;

                $repaymentDate = date('Y-m-d', strtotime($date . ' + ' . ($i * (12 / $typeRemboursement['repetition_annuelle']) + $delaiRemboursement) . ' months'));

                $remboursementPretModel->create([
                    'id_pret_client' => $pretId,
                    'numero_periode' => $i,
                    'date_remboursement' => $repaymentDate,
                    'montant_echeance' => $totalDue,
                    'montant_interet' => $interest,
                    'montant_assurance' => $duePeriodiqueAssurance,
                    'montant_capital_rembourse' => $capitalRepaid,
                    'capital_restant_du' => $newRemainingCapital
                ]);

                $mouvementClientModel->create([
                    'id_client' => $contract['id_client'],
                    'id_type_mouvement' => 2, // Remboursement Prêt
                    'montant' => -$duePeriodiqueAvecInteret,
                    'date_mouvement' => $repaymentDate
                ]);

                $mouvementEtablissementModel->create([
                    'id_etablissement' => 1,
                    'id_type_mouvement' => 2, // Entrée Remboursement
                    'montant' => $duePeriodiqueAvecInteret,
                    'date_mouvement' => $repaymentDate
                ]);

                $remainingCapital = $newRemainingCapital;
            }

            $model->db()->commit();
            Flight::json(['message' => 'Contrat approuvé']);
        } catch (Exception $e) {
            $model->db()->rollBack();
            Flight::json(['error' => 'Erreur lors de l\'approbation du contrat: ' . $e->getMessage()], 500);
        }
    }

    public static function reject($id) {
        $statusModel = new MouvementStatusContrat();
        $statusModel->create([
            'id_contrat_pret' => $id,
            'id_status_contrat' => 3, // Refusé
            'date_mouvement' => date('Y-m-d')
        ]);
        Flight::json(['message' => 'Contrat refusé']);
    }
}