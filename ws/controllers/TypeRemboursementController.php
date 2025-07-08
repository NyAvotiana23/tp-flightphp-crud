<?php
require_once __DIR__ . '/../models/TypeRemboursement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeRemboursementController {
    public static function getAll() {
        $model = new TypeRemboursement();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new TypeRemboursement();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new TypeRemboursement();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new TypeRemboursement();
        $data = Flight::request()->data->getData();
        $model->update($id, $data);
        Flight::json(['message' => 'Type de remboursement modifié']);
    }

    public static function delete($id) {
        $model = new TypeRemboursement();
        $model->delete($id);
        Flight::json(['message' => 'Type de remboursement supprimé']);
    }

    public static function getStatsInteretsParMois($dateDebut, $dateFin) {
        $sql = "
            SELECT 
                YEAR(date_remboursement) as annee,
                MONTH(date_remboursement) as mois,
                SUM(interets) as total_interets
            FROM 
                EF_types_remboursements
            WHERE 
                date_remboursement BETWEEN :dateDebut AND :dateFin
            GROUP BY 
                annee, mois
            ORDER BY 
                annee, mois;
        ";

        try {
            $db = Flight::db();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':dateDebut', $dateDebut);
            $stmt->bindParam(':dateFin', $dateFin);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer l'erreur de base de données
            return ['error' => $e->getMessage()];
        }
    }
}
