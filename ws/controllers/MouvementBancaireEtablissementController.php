<?php
require_once __DIR__ . '/../models/MouvementBancaireEtablissement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class MouvementBancaireEtablissementController {
    public static function getAll() {
        $model = new MouvementBancaireEtablissement();
        $items = $model->getAll();
        Flight::json($items);
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
