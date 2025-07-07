<?php
// Etudiant.php
// This class extends BaseModel to provide specific model functionality for the 'etudiant' table.

// Adjust the path to BaseModel.php based on your actual file structure.
// If BaseModel.php is in the same directory as db.php, and db.php is one level up from models/,
// then this path should be correct.
require_once 'BaseModel.php';

class Etudiant extends BaseModel {
    /**
     * Constructor for Etudiant model.
     * Initializes the BaseModel with the 'etudiant' table name.
     */
    public function __construct() {
        parent::__construct('etudiant');
    }

    // You can add Etudiant-specific methods here if needed,
    // which might use the inherited BaseModel methods or raw queries.
    // For example:
    /*
    public function getStudentsByAgeRange($minAge, $maxAge) {
        return $this->filter([
            ['column' => 'age', 'operator' => '>=', 'value' => $minAge],
            ['column' => 'age', 'operator' => '<=', 'value' => $maxAge]
        ]);
    }

    public function getStudentsWithSpecificEmailDomain($domain) {
        return $this->rawFetch("SELECT * FROM etudiant WHERE email LIKE ?", ['%' . $domain]);
    }
    */
}