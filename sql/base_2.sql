DROP TABLE IF EXISTS EF_retraits_fonds;
DROP TABLE IF EXISTS EF_fonds_investis_clients;
DROP TABLE IF EXISTS EF_mouvements_partenaire;
DROP TABLE IF EXISTS EF_partenaire;
DROP TABLE IF EXISTS EF_type_partenaire;

DROP TABLE IF EXISTS EF_remboursements_prets;
DROP TABLE IF EXISTS EF_prets_clients;
DROP TABLE IF EXISTS EF_mouvement_status_contrat;
DROP TABLE IF EXISTS EF_contrats_prets;
DROP TABLE IF EXISTS EF_status_contrat;
DROP TABLE IF EXISTS EF_types_prets;
DROP TABLE IF EXISTS EF_types_remboursements;

DROP TABLE IF EXISTS EF_mouvements_bancaires_etablissements;
DROP TABLE IF EXISTS EF_types_mouvements_etablissements;
DROP TABLE IF EXISTS EF_etablissements_financiers;

DROP TABLE IF EXISTS EF_mouvements_bancaires_clients;
DROP TABLE IF EXISTS EF_types_mouvements_bancaires;
DROP TABLE IF EXISTS EF_activites_clients;
DROP TABLE IF EXISTS EF_types_contrats_activite;

DROP TABLE IF EXISTS EF_clients;

CREATE TABLE EF_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_client VARCHAR(20) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    adresse TEXT,
    telephone VARCHAR(20)
);

CREATE TABLE EF_types_contrats_activite (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_contrat VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE EF_activites_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_type_contrat INT NOT NULL,
    nom_activite VARCHAR(150) NOT NULL,
    revenu_net_mensuel DECIMAL(12,2) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NULL,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_contrat) REFERENCES EF_types_contrats_activite(id)
);

CREATE TABLE EF_types_mouvements_bancaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_mouvement VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE EF_mouvements_bancaires_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_type_mouvement INT NOT NULL,
    date_mouvement DATE NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_mouvement) REFERENCES EF_types_mouvements_bancaires(id)
);

CREATE TABLE EF_etablissements_financiers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_identification VARCHAR(50) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom_etablissement VARCHAR(150) NOT NULL,
    adresse_etablissement TEXT,
    telephone VARCHAR(20),
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE EF_types_mouvements_etablissements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_mouvement VARCHAR(100) NOT NULL
);

CREATE TABLE EF_mouvements_bancaires_etablissements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_etablissement INT NOT NULL,
    id_type_mouvement INT NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    date_mouvement DATE NOT NULL,
    FOREIGN KEY (id_etablissement) REFERENCES EF_etablissements_financiers(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_mouvement) REFERENCES EF_types_mouvements_etablissements(id)
);


CREATE TABLE EF_types_remboursements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_remboursement VARCHAR(50) NOT NULL,
    repetition_annuelle INT NOT NULL -- nombre de fois par an (12=mensuel, 4=trimestriel, 1=annuel)
);

CREATE TABLE EF_types_prets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_pret VARCHAR(100) NOT NULL,
    taux_interet_min_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    taux_interet_max_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    motif TEXT
);

CREATE TABLE EF_contrats_prets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_type_remboursement INT NOT NULL,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    id_type_pret INT NOT NULL,
    taux_interet_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    taux_assurance_annuel DECIMAL(5,2) DEFAULT 0, -- en pourcentage
    duree_remboursement_mois INT NOT NULL,
    montant_pret DECIMAL(12,2) NOT NULL,
    montant_echeance DECIMAL(12,2) NOT NULL,
    delay_remboursement_mois INT NOT NULL,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type_remboursement) REFERENCES EF_types_remboursements(id),
    FOREIGN KEY (id_type_pret) REFERENCES EF_types_prets(id)
);

alter table EF_contrats_prets add column delay_remboursement_mois INT NOT NULL;

CREATE TABLE EF_status_contrat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE EF_mouvement_status_contrat (
     id INT PRIMARY KEY AUTO_INCREMENT,
     id_contrat_pret INT NOT NULL,
     id_status_contrat INT NOT NULL,
     date_mouvement DATE NOT NULL,
     FOREIGN KEY (id_contrat_pret) REFERENCES EF_contrats_prets(id) ON DELETE CASCADE,
     FOREIGN KEY (id_status_contrat) REFERENCES EF_status_contrat(id) ON DELETE CASCADE
);


CREATE TABLE EF_prets_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_contrat_pret INT NOT NULL,
    montant_pret DECIMAL(12,2) NOT NULL,
    montant_total_a_rembourser DECIMAL(12,2) NOT NULL, -- calculé
    nombre_periodes INT NOT NULL, -- calculé
    montant_echeance_periodique DECIMAL(12,2) NOT NULL, -- calculé
    montant_assurance_periodique DECIMAL(12,2) NOT NULL, -- calculé
    date_debut_pret DATE NOT NULL,
    date_fin_prevue_pret DATE NULL,
    FOREIGN KEY (id_contrat_pret) REFERENCES EF_contrats_prets(id) ON DELETE CASCADE
);

CREATE TABLE EF_remboursements_prets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_pret_client INT NOT NULL,
    numero_periode INT NOT NULL,
    date_remboursement DATE NULL,
    montant_echeance DECIMAL(12,2) NOT NULL, -- amortissement total
    montant_interet DECIMAL(12,2) NOT NULL,
    montant_assurance DECIMAL(12,2) NOT NULL,
    montant_capital_rembourse DECIMAL(12,2) NOT NULL,
    capital_restant_du DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_pret_client) REFERENCES EF_prets_clients(id) ON DELETE CASCADE
);

CREATE TABLE EF_type_partenaire (
    id INT PRIMARY KEY AUTO_INCREMENT,
    designation TEXT
);

CREATE TABLE EF_partenaire (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_type_partenaire INT NOT NULL,
    nom_partenaire VARCHAR(55),
    description_partenaire TEXT,
    commentaire TEXT
);

CREATE TABLE EF_mouvements_partenaire (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_partenaire INT NOT NULL,
    date_changement DATE NOT NULL,
    duree_maximale_jours INT NULL, -- en jours
    duree_minimale_jours INT NULL, -- en jours
    depot_minimum DECIMAL(12,2) NOT NULL,
    depot_maximum DECIMAL(12,2) NULL,
    taux_rendement_annuel DECIMAL(5,2) NOT NULL, -- en pourcentage
    FOREIGN KEY (id_partenaire) REFERENCES EF_partenaire(id) ON DELETE CASCADE
);

CREATE TABLE EF_fonds_investis_clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_partenaire INT NOT NULL,
    id_client INT NOT NULL,
    montant_investi DECIMAL(12,2) NOT NULL,
    date_investissement DATE NOT NULL,
    FOREIGN KEY (id_partenaire) REFERENCES EF_partenaire(id) ON DELETE CASCADE,
    FOREIGN KEY (id_client) REFERENCES EF_clients(id) ON DELETE CASCADE
);

CREATE TABLE EF_retraits_fonds (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_fond_investi INT NOT NULL,
    date_retrait DATE NOT NULL,
    montant_retrait DECIMAL(12,2) NOT NULL,
    montant_interets DECIMAL(12,2) DEFAULT 0,
    motif_retrait TEXT,
    FOREIGN KEY (id_fond_investi) REFERENCES EF_fonds_investis_clients(id) ON DELETE CASCADE
);