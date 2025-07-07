<?php
require_once __DIR__ . '/../models/ActiviteClient.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ActiviteClientController {
    public static function getAll() {
        $model = new ActiviteClient();
        $activitesClients = $model->getAll();
        Flight::json($activitesClients);
    }

    public static function getById($id) {
        $model = new ActiviteClient();
        $activiteClient = $model->getById($id);
        Flight::json($activiteClient);
    }

    public static function create() {
        $model = new ActiviteClient();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new ActiviteClient();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Activité client modifié']);
    }

    public static function delete($id) {
        $model = new ActiviteClient();
        $model->delete($id);
        Flight::json(['message' => 'Activité client supprimée']);
    }
}
