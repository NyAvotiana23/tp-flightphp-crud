<?php
require_once __DIR__ . '/../models/TypeMouvementBancaire.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeMouvementBancaireController {
    public static function getAll() {
        $model = new TypeMouvementBancaire();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new TypeMouvementBancaire();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new TypeMouvementBancaire();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new TypeMouvementBancaire();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Type de mouvement bancaire modifié']);
    }

    public static function delete($id) {
        $model = new TypeMouvementBancaire();
        $model->delete($id);
        Flight::json(['message' => 'Type de mouvement bancaire supprimé']);
    }
}
