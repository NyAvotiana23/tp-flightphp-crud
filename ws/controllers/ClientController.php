<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ClientController {
    public static function getAll() {
        $model = new Client();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new Client();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new Client();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new Client();
        $data = Flight::request()->data->getData();
        $model->update($id, $data);
        Flight::json(['message' => 'Client modifié']);
    }

    public static function delete($id) {
        $model = new Client();
        $model->delete($id);
        Flight::json(['message' => 'Client supprimé']);
    }

    public static function login() {
        $model = new Client();
        $data = Flight::request()->data->getData();
        $numeroClient = $data['numero_client'] ?? null;
        $motDePasse = $data['mot_de_passe'] ?? null;
        if (!$numeroClient || !$motDePasse) {
            Flight::halt(400, json_encode(['error' => 'Numéro client et mot de passe requis']));
        }
        $result = $model->login($numeroClient, $motDePasse);
        if ($result) {
            unset($result['mot_de_passe']); // Remove password from response
            Flight::json($result);
        } else {
            Flight::halt(401, json_encode(['error' => 'Numéro client ou mot de passe incorrect']));
        }
    }
    public static function filter() {
        $model = new Client();
        $data = Flight::request()->data->getData();
        $nom = $data['nom'] ?? '';
        $email = $data['email'] ?? '';
        $numero = $data['numero'] ?? '';

        $items = $model->filterClient($nom, $email, $numero);
        Flight::json($items);
    }
}