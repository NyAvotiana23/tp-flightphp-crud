-- Donnees de test pour la base de donnees EF

-- Insertion des types de contrats d'activite
INSERT INTO EF_types_contrats_activite (nom_type_contrat, description) VALUES
('CDI', 'Contrat à Duree Indeterminee'),
('CDD', 'Contrat à Duree Determinee'),
('Freelance', 'Travailleur independant'),
('Stage', 'Stage professionnel'),
('Interim', 'Travail temporaire');

-- Insertion des clients
INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone) VALUES
('CLI001', '$2y$10$example1', 'Martin', 'Jean', '1985-03-15', 'jean.martin@email.com', '123 Rue de la Paix, 75001 Paris', '0123456789'),
('CLI002', '$2y$10$example2', 'Dubois', 'Marie', '1990-07-22', 'marie.dubois@email.com', '456 Avenue des Champs, 69001 Lyon', '0234567890'),
('CLI003', '$2y$10$example3', 'Moreau', 'Pierre', '1988-11-08', 'pierre.moreau@email.com', '789 Boulevard Saint-Germain, 33000 Bordeaux', '0345678901'),
('CLI004', '$2y$10$example4', 'Leroy', 'Sophie', '1992-04-12', 'sophie.leroy@email.com', '321 Rue Victor Hugo, 13001 Marseille', '0456789012'),
('CLI005', '$2y$10$example5', 'Roux', 'Antoine', '1987-09-25', 'antoine.roux@email.com', '654 Place de la Republique, 59000 Lille', '0567890123');

-- Insertion des activites clients
INSERT INTO EF_activites_clients (id_client, id_type_contrat, nom_activite, revenu_net_mensuel, date_debut, date_fin, statut_actif) VALUES
(1, 1, 'Developpeur Web', 3500.00, '2020-01-15', NULL, TRUE),
(2, 1, 'Comptable', 2800.00, '2019-03-01', NULL, TRUE),
(3, 3, 'Consultant IT', 4200.00, '2021-06-01', NULL, TRUE),
(4, 2, 'Assistante Marketing', 2400.00, '2022-09-15', '2023-09-15', FALSE),
(4, 1, 'Responsable Marketing', 3200.00, '2023-10-01', NULL, TRUE),
(5, 1, 'Ingenieur', 4000.00, '2018-05-20', NULL, TRUE);

-- Insertion des types de mouvements bancaires
INSERT INTO EF_types_mouvements_bancaires (nom_type_mouvement, description) VALUES
('Virement', 'Virement bancaire'),
('Prelevement', 'Prelevement automatique'),
('Cheque', 'Paiement par cheque'),
('Carte bancaire', 'Paiement par carte'),
('Especes', 'Paiement en especes'),
('Salaire', 'Versement de salaire'),
('Remboursement', 'Remboursement de pret');

-- Insertion des mouvements bancaires clients
INSERT INTO EF_mouvements_bancaires_clients (id_client, id_type_mouvement, date_mouvement, montant, description, reference_transaction) VALUES
(1, 6, '2024-01-31', 3500.00, 'Salaire janvier 2024', 'SAL202401001'),
(1, 7, '2024-02-05', -450.00, 'Remboursement pret auto', 'REM202402001'),
(2, 6, '2024-01-31', 2800.00, 'Salaire janvier 2024', 'SAL202401002'),
(2, 1, '2024-02-01', -1200.00, 'Loyer fevrier', 'VIR202402001'),
(3, 6, '2024-01-31', 4200.00, 'Honoraires janvier 2024', 'HON202401001'),
(4, 6, '2024-01-31', 3200.00, 'Salaire janvier 2024', 'SAL202401003'),
(5, 6, '2024-01-31', 4000.00, 'Salaire janvier 2024', 'SAL202401004');

-- Insertion des etablissements financiers
INSERT INTO EF_etablissements_financiers (numero_identification, mot_de_passe, nom_etablissement, adresse_etablissement, ville, code_postal, pays, telephone, email) VALUES
('EF001', '$2y$10$efexample1', 'Banque Centrale Paris', '1 Place Vendôme', 'Paris', '75001', 'France', '0144556677', 'contact@bcparis.fr'),
('EF002', '$2y$10$efexample2', 'Credit Lyonnais', '20 Avenue de la Republique', 'Lyon', '69002', 'France', '0478889900', 'info@creditlyon.fr'),
('EF003', '$2y$10$efexample3', 'Banque Populaire Sud', '50 Cours Mirabeau', 'Marseille', '13001', 'France', '0491223344', 'contact@bpsud.fr');

-- Insertion des types de mouvements etablissements
INSERT INTO EF_types_mouvements_etablissements (nom_type_mouvement, description) VALUES
('Depôt', 'Depôt de fonds'),
('Retrait', 'Retrait de fonds'),
('Transfert entrant', 'Transfert de fonds entrant'),
('Transfert sortant', 'Transfert de fonds sortant'),
('Interets', 'Paiement dinterets');

-- Insertion des mouvements bancaires etablissements
INSERT INTO EF_mouvements_bancaires_etablissements (id_etablissement, id_type_mouvement, montant, date_mouvement, description, reference_transaction) VALUES
(1, 1, 100000.00, '2024-01-15', 'Depôt initial', 'DEP202401001'),
(1, 4, -15000.00, '2024-01-20', 'Pret accorde client CLI001', 'PRE202401001'),
(2, 1, 75000.00, '2024-01-10', 'Depôt initial', 'DEP202401002'),
(3, 1, 50000.00, '2024-01-12', 'Depôt initial', 'DEP202401003');

-- Insertion des types de remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle, description) VALUES
('Mensuel', 12, 'Remboursement mensuel'),
('Trimestriel', 4, 'Remboursement trimestriel'),
('Semestriel', 2, 'Remboursement semestriel'),
('Annuel', 1, 'Remboursement annuel');

-- Insertion des types de prets
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif, description) VALUES
('Pret personnel', 3.00, 8.00, 'Financement personnel', 'Pret pour besoins personnels'),
('Pret auto', 2.50, 6.50, 'Achat vehicule', 'Pret pour l\'achat d\'un vehicule'),
('Pret immobilier', 1.50, 4.00, 'Achat immobilier', 'Pret pour l\'achat d\'un bien immobilier'),
('Pret travaux', 2.00, 7.00, 'Renovation', 'Pret pour travaux de renovation'),
('Pret etudiant', 1.00, 3.00, 'etudes', 'Pret pour financer les etudes');

-- Insertion des contrats de prets
INSERT INTO EF_contrats_prets (id_client, id_type_remboursement, uuid, id_type_pret, taux_interet_annuel, duree_remboursement_mois, montant_pret, montant_echeance, date_signature, statut_contrat) VALUES
(1, 1, 'a1b2c3d4-e5f6-7890-abcd-ef1234567890', 2, 4.50, 60, 15000.00, 280.19, '2023-06-15', 'actif'),
(2, 1, 'b2c3d4e5-f6g7-8901-bcde-f23456789012', 1, 6.00, 36, 8000.00, 243.15, '2023-09-10', 'actif'),
(3, 2, 'c3d4e5f6-g7h8-9012-cdef-345678901234', 4, 5.50, 48, 25000.00, 1521.88, '2023-04-20', 'actif'),
(4, 1, 'd4e5f6g7-h8i9-0123-defg-456789012345', 1, 7.20, 24, 5000.00, 228.89, '2024-01-05', 'actif'),
(5, 1, 'e5f6g7h8-i9j0-1234-efgh-567890123456', 3, 3.20, 240, 180000.00, 890.45, '2022-03-12', 'actif');

-- Insertion des prets clients
INSERT INTO EF_prets_clients (id_contrat_pret, montant_pret, montant_total_a_rembourser, nombre_periodes, montant_echeance_periodique, date_debut_pret, date_fin_prevue_pret, statut_pret) VALUES
(1, 15000.00, 16811.40, 60, 280.19, '2023-06-20', '2028-06-20', 'en_cours'),
(2, 8000.00, 8753.40, 36, 243.15, '2023-09-15', '2026-09-15', 'en_cours'),
(3, 25000.00, 30525.00, 16, 1521.88, '2023-04-25', '2027-04-25', 'en_cours'),
(4, 5000.00, 5493.36, 24, 228.89, '2024-01-10', '2026-01-10', 'en_cours'),
(5, 180000.00, 213708.00, 240, 890.45, '2022-03-15', '2042-03-15', 'en_cours');

-- Insertion de quelques remboursements (exemples pour les premiers mois)
INSERT INTO EF_remboursements_prets (id_pret_client, numero_periode, date_echeance_prevue, date_remboursement_effectif, montant_echeance, montant_interet, montant_capital_rembourse, capital_restant_du, statut_remboursement, montant_paye) VALUES
-- Pret 1 (Client 1)
(1, 1, '2023-07-20', '2023-07-18', 280.19, 56.25, 223.94, 14776.06, 'paye', 280.19),
(1, 2, '2023-08-20', '2023-08-20', 280.19, 55.41, 224.78, 14551.28, 'paye', 280.19),
(1, 3, '2023-09-20', '2023-09-19', 280.19, 54.57, 225.62, 14325.66, 'paye', 280.19),
(1, 4, '2023-10-20', NULL, 280.19, 53.72, 226.47, 14099.19, 'en_attente', 0.00),
-- Pret 2 (Client 2)
(2, 1, '2023-10-15', '2023-10-15', 243.15, 40.00, 203.15, 7796.85, 'paye', 243.15),
(2, 2, '2023-11-15', '2023-11-16', 243.15, 38.98, 204.17, 7592.68, 'paye', 243.15),
(2, 3, '2023-12-15', NULL, 243.15, 37.96, 205.19, 7387.49, 'en_attente', 0.00);

-- Insertion des types de fonds
INSERT INTO EF_types_fonds (nom_type_fond, description) VALUES
('epargne classique', 'Livret d\'epargne traditionnel'),
('Placement à terme', 'Depôt à terme fixe'),
('Investissement actions', 'Fonds d\'investissement en actions'),
('Obligations', 'Fonds obligataire'),
('Mixte', 'Fonds mixte actions/obligations');

-- Insertion des produits d'investissements
INSERT INTO EF_produits_investissements (nom_produit, description_produit, commentaire, statut_produit) VALUES
('Livret Plus', 'Livret depargne remunere', 'Taux attractif garanti 6 mois', 'actif'),
('Terme 12 mois', 'Placement à terme 12 mois', 'Rendement fixe sur 12 mois', 'actif'),
('Actions Europe', 'Fonds actions europeennes', 'Investissement dynamique', 'actif'),
('Obligations France', 'Fonds obligataire français', 'Investissement securise', 'actif'),
('equilibre', 'Fonds equilibre 50/50', 'Compromis risque/rendement', 'actif');

-- Insertion des types de partenaires
INSERT INTO EF_type_partenaire (description) VALUES
('Banque partenaire'),
('Societe de gestion'),
('Courtier en assurance'),
('etablissement de credit'),
('Plateforme dinvestissement');

-- Insertion des partenaires
INSERT INTO EF_partenaire (id_type_partenaire, nom_partenaire, description_partenaire, commentaire) VALUES
(1, 'BNP Paribas', 'Banque de reference', 'Partenariat privilegie'),
(2, 'Amundi', 'Leader de la gestion dactifs', 'Fonds diversifies'),
(3, 'AXA Investments', 'Specialiste assurance-vie', 'Produits vie et capitalisation'),
(4, 'Societe Generale', 'Banque universelle', 'Produits de financement'),
(5, 'Boursorama', 'Banque en ligne', 'Placements digitaux');

-- Insertion des mouvements partenaires
INSERT INTO EF_mouvements_partenaire (id_partenaire, date_changement, duree_maximale_jours, duree_minimale_jours, depot_minimum, depot_maximum, taux_rendement_annuel, statut_mouvement) VALUES
(1, '2024-01-01', 365, 30, 1000.00, 100000.00, 2.50, 'actif'),
(2, '2024-01-01', 1095, 365, 5000.00, 500000.00, 4.20, 'actif'),
(3, '2024-01-01', 2555, 1095, 10000.00, 1000000.00, 3.80, 'actif'),
(4, '2024-01-01', 730, 180, 2000.00, 200000.00, 3.20, 'actif'),
(5, '2024-01-01', 1825, 365, 1000.00, 50000.00, 2.80, 'actif');

-- Insertion des fonds investis par les clients
INSERT INTO EF_fonds_investis_clients (id_partenaire, id_client, montant_investi, date_investissement, date_echeance_prevue, taux_rendement_applique, statut_investissement, montant_actuel) VALUES
(1, 1, 5000.00, '2023-06-01', '2024-06-01', 2.50, 'actif', 5104.17),
(2, 2, 15000.00, '2023-01-15', '2024-01-15', 4.20, 'echu', 15630.00),
(3, 3, 25000.00, '2022-10-01', '2025-10-01', 3.80, 'actif', 26900.00),
(4, 4, 8000.00, '2023-09-01', '2024-03-01', 3.20, 'actif', 8128.00),
(5, 5, 12000.00, '2023-03-01', '2024-03-01', 2.80, 'actif', 12336.00),
(1, 2, 3000.00, '2023-12-01', '2024-12-01', 2.50, 'actif', 3020.83);

-- Insertion des retraits de fonds
INSERT INTO EF_retraits_fonds (id_fond_investi, date_retrait, montant_retrait, montant_interets, montant_penalite, motif_retrait, statut_retrait) VALUES
(2, '2024-01-15', 15630.00, 630.00, 0.00, 'echeance normale', 'valide'),
(3, '2023-12-15', 5000.00, 190.00, 150.00, 'Retrait anticipe partiel', 'valide'),
(4, '2024-02-01', 2000.00, 32.00, 0.00, 'Besoin de tresorerie', 'en_attente');

