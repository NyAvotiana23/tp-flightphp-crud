<?php
require_once __DIR__ . '/../models/MouvementBancaireEtablissement.php';
require_once __DIR__ . '/../helpers/Utils.php';
require_once __DIR__ . '/../models/EtablissementFinancier.php';

class MouvementBancaireEtablissementController {
    public static function getAll() {
        $model = new MouvementBancaireEtablissement();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getByEtablissement($idEtablissement)
    {
        $model = new MouvementBancaireEtablissement();
        $sql = "
            SELECT * FROM EF_mouvements_bancaires_etablissements 
            WHERE id_etablissement = ?
        ";
        return $model->rawFetch($sql, [$idEtablissement]);
    }

    public static function getByFirstEtablissement()
    {
        $dateDebut = Flight::request()->query['date_debut'] ?? null;
        $dateFin = Flight::request()->query['date_fin'] ?? null;
        $typeMouvementId = Flight::request()->query['type_mouvement_id'] ?? null;

        $etModel = new EtablissementFinancier();
        $etFirst = $etModel->getFirst();
        $id = $etFirst["id"];

        $model = new MouvementBancaireEtablissement();

        $sql = "
            SELECT 
                mbe.date_mouvement,
                mbe.montant, 
                tme.nom_type_mouvement
            FROM EF_mouvements_bancaires_etablissements mbe
            JOIN EF_types_mouvements_etablissements tme 
                ON mbe.id_type_mouvement = tme.id
            WHERE mbe.id_etablissement = ?
        ";

        $params = [$id];

        if ($dateDebut) {
            $sql .= " AND mbe.date_mouvement >= ?";
            $params[] = $dateDebut;
        }

        if ($dateFin) {
            $sql .= " AND mbe.date_mouvement <= ?";
            $params[] = $dateFin;
        }

        if ($typeMouvementId) {
            $sql .= " AND mbe.id_type_mouvement = ?";
            $params[] = $typeMouvementId;
        }

        $sql .= " ORDER BY mbe.date_mouvement ASC";

        $res = $model->rawFetch($sql, $params);
        return Flight::json($res);
    }


    public static function getById($id) {
        $model = new MouvementBancaireEtablissement();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new MouvementBancaireEtablissement();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new MouvementBancaireEtablissement();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement bancaire établissement modifié']);
    }

    public static function delete($id) {
        $model = new MouvementBancaireEtablissement();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement bancaire établissement supprimé']);
    }
}
