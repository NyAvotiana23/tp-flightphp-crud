<?php
require_once __DIR__ . '/../models/MouvementPartenaire.php';
require_once __DIR__ . '/../helpers/Utils.php';

class MouvementPartenaireController {
    public static function getAll() {
        $model = new MouvementPartenaire();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new MouvementPartenaire();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new MouvementPartenaire();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new MouvementPartenaire();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement produit modifié']);
    }

    public static function delete($id) {
        $model = new MouvementPartenaire();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement produit supprimé']);
    }
}
