CREATE TABLE EF_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_client VARCHAR(20) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    adresse TEXT,
    telephone VARCHAR(20),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    statut_actif BOOLEAN DEFAULT TRUE
);

-- Table des types de contrats d'activité
CREATE TABLE EF_types_contrats_activite (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_contrat VARCHAR(100) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des activités professionnelles des clients
CREATE TABLE EF_activites_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_type_contrat INT NOT NULL,
    nom_activite VARCHAR(150) NOT NULL,
    revenu_net_mensuel DECIMAL(12,2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NULL,
    statut_actif BOOLEAN DEFAULT TRUE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_contrat) REFERENCES EF_types_contrats_activite(id)
);

-- Table des types de mouvements bancaires clients
CREATE TABLE EF_types_mouvements_bancaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_mouvement VARCHAR(100) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des mouvements bancaires des clients
CREATE TABLE EF_mouvements_bancaires_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_type_mouvement INT NOT NULL,
    date_mouvement DATE NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    description TEXT,
    reference_transaction VARCHAR(100),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_mouvement) REFERENCES EF_types_mouvements_bancaires(id)
);

-- Table des établissements financiers
CREATE TABLE EF_etablissements_financiers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_identification VARCHAR(50) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom_etablissement VARCHAR(150) NOT NULL,
    adresse_etablissement TEXT,
    ville VARCHAR(100),
    code_postal VARCHAR(10),
    pays VARCHAR(100),
    telephone VARCHAR(20),
    email VARCHAR(150),
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    statut_actif BOOLEAN DEFAULT TRUE
);

-- Table des types de mouvements pour établissements financiers
CREATE TABLE EF_types_mouvements_etablissements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_mouvement VARCHAR(100) NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des mouvements bancaires des établissements financiers
CREATE TABLE EF_mouvements_bancaires_etablissements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_etablissement INT NOT NULL,
    id_type_mouvement INT NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    date_mouvement DATE NOT NULL,
    description TEXT,
    reference_transaction VARCHAR(100),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_etablissement) REFERENCES EF_etablissements_financiers(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_mouvement) REFERENCES EF_types_mouvements_etablissements(id)
);

CREATE TABLE EF_types_remboursements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_remboursement VARCHAR(50) NOT NULL,
    repetition_annuelle INT NOT NULL, -- nombre de fois par an (12=mensuel, 4=trimestriel, 1=annuel)
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des types de prêts
CREATE TABLE EF_types_prets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_pret VARCHAR(100) NOT NULL,
    taux_interet_min_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    taux_interet_max_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    motif TEXT,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des contrats de prêt
CREATE TABLE EF_contrats_prets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_type_remboursement INT NOT NULL,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    id_type_pret INT NOT NULL,
    taux_interet_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    duree_remboursement_mois INT NOT NULL,
    montant_pret DECIMAL(12,2) NOT NULL,
    montant_echeance DECIMAL(12,2) NOT NULL,
    date_signature DATE NOT NULL,
    statut_contrat ENUM('actif', 'termine', 'suspendu', 'annule') DEFAULT 'actif',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_remboursement) REFERENCES EF_types_remboursements(id),
    FOREIGN KEY (id_type_pret) REFERENCES EF_types_prets(id)
);

-- Table des prêts accordés aux clients
CREATE TABLE EF_prets_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_contrat_pret INT NOT NULL,
    montant_pret DECIMAL(12,2) NOT NULL,
    montant_total_a_rembourser DECIMAL(12,2) NOT NULL, -- calculé
    nombre_periodes INT NOT NULL, -- calculé
    montant_echeance_periodique DECIMAL(12,2) NOT NULL, -- calculé
    date_debut_pret DATE NOT NULL,
    date_fin_prevue_pret DATE NOT NULL,
    date_fin_reelle_pret DATE NULL,
    statut_pret ENUM('en_cours', 'rembourse', 'en_retard', 'defaillant') DEFAULT 'en_cours',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_contrat_pret) REFERENCES EF_contrats_prets(id) ON DELETE CASCADE
);

-- Table des remboursements de prêts
CREATE TABLE EF_remboursements_prets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pret_client INT NOT NULL,
    numero_periode INT NOT NULL,
    date_echeance_prevue DATE NOT NULL,
    date_remboursement_effectif DATE NULL,
    montant_echeance DECIMAL(12,2) NOT NULL, -- amortissement total
    montant_interet DECIMAL(12,2) NOT NULL,
    montant_capital_rembourse DECIMAL(12,2) NOT NULL,
    capital_restant_du DECIMAL(12,2) NOT NULL,
    statut_remboursement ENUM('en_attente', 'paye', 'en_retard', 'paye_partiel') DEFAULT 'en_attente',
    montant_paye DECIMAL(12,2) DEFAULT 0,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pret_client) REFERENCES EF_prets_clients(id) ON DELETE CASCADE
);