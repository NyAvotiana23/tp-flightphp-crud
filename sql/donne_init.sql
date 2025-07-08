-- Inserting data into EF_type_partenaire
INSERT INTO EF_type_partenaire (designation) VALUES
         ('Banque'),
         ('Société d\'investissement'),
         ('Coopérative');

-- Inserting data into EF_partenaire
INSERT INTO EF_partenaire (id_type_partenaire, nom_partenaire, description_partenaire, commentaire) VALUES
    (1, 'Banque Nationale', 'Banque commerciale principale', 'Partenaire fiable depuis 2005'),
    (2, 'InvestPlus', 'Société d\'investissement spécialisée', 'Focus sur les PME'),
    (3, 'Coop Épargne', 'Coopérative de microcrédit', 'Soutien aux entrepreneurs locaux');

-- Inserting data into EF_status_contrat
INSERT INTO EF_status_contrat (libelle) VALUES
    ('en_attente'),
    ('valider'),
    ('refuser');

-- Inserting data into EF_types_prets
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif) VALUES
    ('Prêt personnel', 3.50, 7.00, 'Financement de projets personnels'),
    ('Prêt immobilier', 2.00, 4.50, 'Achat de biens immobiliers'),
    ('Prêt entrepreneurial', 5.00, 9.00, 'Soutien aux activités entrepreneuriales');

-- Inserting data into EF_types_remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle) VALUES
    ('mensuel', 12),
    ('trimestriel', 4),
    ('annuel', 1);

-- Inserting data into EF_types_mouvements_etablissements
INSERT INTO EF_types_mouvements_etablissements (nom_type_mouvement) VALUES
    ('Gain Fond'),
    ('Retour Fond'),
    ('Sortis Pret'),
    ('Rembourssement Pret');

-- Inserting data into EF_etablissements_financiers
INSERT INTO EF_etablissements_financiers (numero_identification, mot_de_passe, nom_etablissement, adresse_etablissement, telephone, commentaire) VALUES
     ('BN12345', 'hashed_password1', 'Banque Nationale', '123 Rue Principale, Paris', '0123456789', 'Banque principale'),
     ('IP67890', 'hashed_password2', 'InvestPlus', '456 Avenue des Champs, Lyon', '0987654321', 'Investissements PME'),
     ('CE54321', 'hashed_password3', 'Coop Épargne', '789 Boulevard Coop, Marseille', '0123987654', 'Microcrédit');

-- Inserting data into EF_types_mouvements_bancaires
INSERT INTO EF_types_mouvements_bancaires (nom_type_mouvement, description) VALUES
    ('Fond investissement', 'Investissement dans un fonds'),
    ('Pret', 'Obtention d\'un prêt'),
    ('Rembourssement Pret', 'Remboursement d\'une échéance de prêt'),
    ('Activite', 'Revenus d\'activité'),
    ('Budget Initial', 'Dépôt initial'),
    ('Autres', 'Autres transactions');

-- Inserting data into EF_types_contrats_activite
INSERT INTO EF_types_contrats_activite (nom_type_contrat, description) VALUES
    ('CDI', 'Contrat à durée indéterminée'),
    ('CDD', 'Contrat à durée déterminée'),
    ('Freelance', 'Activité indépendante');

-- Inserting data into EF_clients
INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone) VALUES
    ('CL001', 'hashed_password4', 'Dupont', 'Jean', '1985-03-15', 'jean.dupont@email.com', '12 Rue de la Paix, Paris', '0612345678'),
    ('CL002', 'hashed_password5', 'Martin', 'Sophie', '1990-07-22', 'sophie.martin@email.com', '34 Avenue Liberté, Lyon', '0698765432'),
    ('CL003', 'hashed_password6', 'Lefèvre', 'Paul', '1978-11-30', 'paul.lefevre@email.com', '56 Rue du Commerce, Marseille', '0623456789');

-- Inserting data into EF_activites_clients
INSERT INTO EF_activites_clients (id_client, id_type_contrat, nom_activite, revenu_net_mensuel, date_debut, date_fin) VALUES
    (1, 1, 'Ingénieur logiciel', 3500.00, '2020-01-01', NULL),
    (2, 3, 'Graphiste freelance', 2500.00, '2022-06-01', NULL),
    (3, 2, 'Vendeur', 1800.00, '2023-03-01', '2024-03-01');