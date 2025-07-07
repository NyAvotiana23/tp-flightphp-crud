<?php
require_once __DIR__ . '/../models/MouvementProduit.php';
require_once __DIR__ . '/../helpers/Utils.php';

class MouvementProduitController {
    public static function getAll() {
        $model = new MouvementProduit();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new MouvementProduit();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new MouvementProduit();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new MouvementProduit();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement produit modifié']);
    }

    public static function delete($id) {
        $model = new MouvementProduit();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement produit supprimé']);
    }
}
