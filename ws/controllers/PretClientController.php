<?php
require_once __DIR__ . '/../models/PretClient.php';
require_once __DIR__ . '/../helpers/Utils.php';

class PretClientController {
    public static function getAll() {
        $model = new PretClient();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new PretClient();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new PretClient();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new PretClient();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Prêt client modifié']);
    }

    public static function delete($id) {
        $model = new PretClient();
        $model->delete($id);
        Flight::json(['message' => 'Prêt client supprimé']);
    }

    public static function filterLoans() {
        $model = new PretClient();
        $data = Flight::request()->data->getData();

        $conditions = [];
        $params = [];

        // Filter by date_debut_pret
        if (!empty($data['date_debut_pret'])) {
            $conditions[] = "pc.date_debut_pret = ?";
            $params[] = $data['date_debut_pret'];
        }

        // Filter by date_fin_prevue_pret
        if (!empty($data['date_fin_prevue_pret'])) {
            $conditions[] = "pc.date_fin_prevue_pret = ?";
            $params[] = $data['date_fin_prevue_pret'];
        }

        // Filter by loan type (id_type_pret)
        if (!empty($data['id_type_pret'])) {
            $conditions[] = "cp.id_type_pret = ?";
            $params[] = $data['id_type_pret'];
        }

        // Filter by repayment type (id_type_remboursement)
        if (!empty($data['id_type_remboursement'])) {
            $conditions[] = "cp.id_type_remboursement = ?";
            $params[] = $data['id_type_remboursement'];
        }

        // Filter by status (id_status_contrat)
        if (!empty($data['id_status_contrat'])) {
            $conditions[] = "msc.id_status_contrat = ?";
            $params[] = $data['id_status_contrat'];
        }

        // Build the SQL query with joins
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql = "
            SELECT pc.*, cp.id_type_pret, cp.id_type_remboursement, cp.id as contrat_id, cp.uuid, cp.taux_interet_annuel, 
                   cp.taux_assurance_annuel, cp.duree_remboursement_mois, cp.montant_pret, cp.montant_echeance,
                   tp.nom_type_pret, tr.nom_type_remboursement, sc.libelle as status_libelle, msc.date_mouvement as status_date
            FROM EF_prets_clients pc
            INNER JOIN EF_contrats_prets cp ON pc.id_contrat_pret = cp.id
            INNER JOIN EF_types_prets tp ON cp.id_type_pret = tp.id
            INNER JOIN EF_types_remboursements tr ON cp.id_type_remboursement = tr.id
            LEFT JOIN EF_mouvement_status_contrat msc ON cp.id = msc.id_contrat_pret
            LEFT JOIN EF_status_contrat sc ON msc.id_status_contrat = sc.id
            $whereClause
            ORDER BY pc.id, status_date DESC
        ";

        try {
            $result = $model->rawFetch($sql, $params);
            Flight::json($result);
        } catch (PDOException $e) {
            Flight::json(['error' => 'Erreur lors du filtrage des prêts: ' . $e->getMessage()], 500);
        }
    }

    public static function getLoanDetails($id) {
        $model = new PretClient();

        // Fetch loan and contract details
        $sqlLoan = "
            SELECT pc.*, cp.id as contrat_id, cp.uuid, cp.taux_interet_annuel, cp.taux_assurance_annuel, 
                   cp.duree_remboursement_mois, cp.montant_pret, cp.montant_echeance, 
                   tp.nom_type_pret, tr.nom_type_remboursement, c.nom as client_nom, c.prenom as client_prenom
            FROM EF_prets_clients pc
            INNER JOIN EF_contrats_prets cp ON pc.id_contrat_pret = cp.id
            INNER JOIN EF_types_prets tp ON cp.id_type_pret = tp.id
            INNER JOIN EF_types_remboursements tr ON cp.id_type_remboursement = tr.id
            INNER JOIN EF_clients c ON cp.id_client = c.id
            WHERE pc.id = ?
        ";
        $loan = $model->rawFetch($sqlLoan, [$id]);

        if (empty($loan)) {
            Flight::json(['error' => 'Prêt non trouvé'], 404);
            return;
        }

        // Fetch latest status
        $sqlStatus = "
            SELECT sc.libelle, msc.date_mouvement
            FROM EF_mouvement_status_contrat msc
            INNER JOIN EF_status_contrat sc ON msc.id_status_contrat = sc.id
            WHERE msc.id_contrat_pret = ?
            ORDER BY msc.date_mouvement DESC
            LIMIT 1
        ";
        $status = $model->rawFetch($sqlStatus, [$loan[0]['contrat_id']]);

        // Fetch repayment history
        $sqlRepayments = "
            SELECT rp.numero_periode, rp.date_remboursement, rp.montant_echeance, 
                   rp.montant_interet, rp.montant_assurance, rp.montant_capital_rembourse, rp.capital_restant_du
            FROM EF_remboursements_prets rp
            WHERE rp.id_pret_client = ?
            ORDER BY rp.numero_periode
        ";
        $repayments = $model->rawFetch($sqlRepayments, [$id]);

        $response = [
            'contract' => [
                'id' => $loan[0]['contrat_id'],
                'uuid' => $loan[0]['uuid'],
                'repaymentType' => $loan[0]['nom_type_remboursement'],
                'revenueRate' => $loan[0]['taux_interet_annuel'],
                'insuranceRate' => $loan[0]['taux_assurance_annuel'],
                'duration' => $loan[0]['duree_remboursement_mois'],
                'amount' => $loan[0]['montant_pret'],
                'dueDate' => $loan[0]['date_fin_prevue_pret'],
                'client' => $loan[0]['client_prenom'] . ' ' . $loan[0]['client_nom'],
                'loanType' => $loan[0]['nom_type_pret']
            ],
            'status' => !empty($status) ? [
                'libelle' => $status[0]['libelle'],
                'date' => $status[0]['date_mouvement']
            ] : null,
            'repayments' => array_map(function($repayment) {
                return [
                    'index_period' => $repayment['numero_periode'],
                    'date_retour' => $repayment['date_remboursement'],
                    'total_due' => $repayment['montant_echeance'],
                    'interet' => $repayment['montant_interet'],
                    'capital_rembourse' => $repayment['montant_capital_rembourse'],
                    'capital_restant' => $repayment['capital_restant_du']
                ];
            }, $repayments)
        ];

        Flight::json($response);
    }
}
?>