<?php
require_once __DIR__ . '/../models/MouvementBancaireClient.php';
require_once __DIR__ . '/../helpers/Utils.php';

class MouvementBancaireClientController {
    public static function getAll() {
        $model = new MouvementBancaireClient();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new MouvementBancaireClient();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new MouvementBancaireClient();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new MouvementBancaireClient();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement bancaire client modifié']);
    }

    public static function delete($id) {
        $model = new MouvementBancaireClient();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement bancaire client supprimé']);
    }
}
