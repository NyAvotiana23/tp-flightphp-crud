<?php
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../helpers/Utils.php';

class EtudiantController {
    public static function getAll() {
        $model = new Etudiant();
        $etudiants = $model->getAll();
        Flight::json($etudiants);
    }

    public static function getById($id) {
        $model = new Etudiant();
        $etudiant = $model->getById($id);
        Flight::json($etudiant);
    }

    public static function create() {
        $model = new Etudiant();
        $model = new Etudiant();
        $data = Flight::request()->data;

        $id = $model->create($data);
        $dateFormatted = Utils::formatDate('2025-01-01');
        Flight::json(['message' => 'Étudiant ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $model = new Etudiant();

        $model = new Etudiant();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Étudiant modifié']);
    }

    public static function delete($id) {
        $model = new Etudiant();

        $model = new Etudiant();
        $model->delete($id);
        Flight::json(['message' => 'Étudiant supprimé']);
    }
}
