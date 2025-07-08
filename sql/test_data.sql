-- Données de test pour la base de données EF (Version mise à jour)

-- Insertion des types de contrats d'activité
INSERT INTO EF_types_contrats_activite (nom_type_contrat, description) VALUES
('CDI', 'Contrat à Durée Indéterminée'),
('CDD', 'Contrat à Durée Déterminée'),
('Freelance', 'Travailleur indépendant'),
('Stage', 'Stage professionnel'),
('Intérim', 'Travail temporaire');

-- Insertion des clients
INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone) VALUES
('CLI001', '$2y$10$example1', 'Martin', 'Jean', '1985-03-15', 'jean.martin@email.com', '123 Rue de la Paix, 75001 Paris', '0123456789'),
('CLI002', '$2y$10$example2', 'Dubois', 'Marie', '1990-07-22', 'marie.dubois@email.com', '456 Avenue des Champs, 69001 Lyon', '0234567890'),
('CLI003', '$2y$10$example3', 'Moreau', 'Pierre', '1988-11-08', 'pierre.moreau@email.com', '789 Boulevard Saint-Germain, 33000 Bordeaux', '0345678901'),
('CLI004', '$2y$10$example4', 'Leroy', 'Sophie', '1992-04-12', 'sophie.leroy@email.com', '321 Rue Victor Hugo, 13001 Marseille', '0456789012'),
('CLI005', '$2y$10$example5', 'Roux', 'Antoine', '1987-09-25', 'antoine.roux@email.com', '654 Place de la République, 59000 Lille', '0567890123');

-- Insertion des activités clients
INSERT INTO EF_activites_clients (id_client, id_type_contrat, nom_activite, revenu_net_mensuel, date_debut, date_fin) VALUES
(1, 1, 'Développeur Web', 3500.00, '2020-01-15', NULL),
(2, 1, 'Comptable', 2800.00, '2019-03-01', NULL),
(3, 3, 'Consultant IT', 4200.00, '2021-06-01', NULL),
(4, 2, 'Assistante Marketing', 2400.00, '2022-09-15', '2023-09-15'),
(4, 1, 'Responsable Marketing', 3200.00, '2023-10-01', NULL),
(5, 1, 'Ingénieur', 4000.00, '2018-05-20', NULL);

-- Insertion des types de mouvements bancaires
INSERT INTO EF_types_mouvements_bancaires (nom_type_mouvement, description) VALUES
('Virement', 'Virement bancaire'),
('Prélèvement', 'Prélèvement automatique'),
('Chèque', 'Paiement par chèque'),
('Carte bancaire', 'Paiement par carte'),
('Espèces', 'Paiement en espèces'),
('Salaire', 'Versement de salaire'),
('Remboursement', 'Remboursement de prêt');

-- Insertion des mouvements bancaires clients
INSERT INTO EF_mouvements_bancaires_clients (id_client, id_type_mouvement, date_mouvement, montant) VALUES
(1, 6, '2024-01-31', 3500.00),
(1, 7, '2024-02-05', -450.00),
(2, 6, '2024-01-31', 2800.00),
(2, 1, '2024-02-01', -1200.00),
(3, 6, '2024-01-31', 4200.00),
(4, 6, '2024-01-31', 3200.00),
(5, 6, '2024-01-31', 4000.00),
(1, 6, '2024-02-29', 3500.00),
(2, 6, '2024-02-29', 2800.00),
(3, 6, '2024-02-29', 4200.00);

-- Insertion des établissements financiers
INSERT INTO EF_etablissements_financiers (numero_identification, mot_de_passe, nom_etablissement, adresse_etablissement, telephone, commentaire) VALUES
('EF001', '$2y$10$efexample1', 'Banque Centrale Paris', '1 Place Vendôme, 75001 Paris', '0144556677', 'Établissement principal'),
('EF002', '$2y$10$efexample2', 'Crédit Lyonnais', '20 Avenue de la République, 69002 Lyon', '0478889900', 'Partenaire régional'),
('EF003', '$2y$10$efexample3', 'Banque Populaire Sud', '50 Cours Mirabeau, 13001 Marseille', '0491223344', 'Spécialiste Sud');

-- Insertion des types de mouvements établissements
INSERT INTO EF_types_mouvements_etablissements (nom_type_mouvement) VALUES
('Dépôt'),
('Retrait'),
('Transfert entrant'),
('Transfert sortant'),
('Intérêts');

-- Insertion des mouvements bancaires établissements
INSERT INTO EF_mouvements_bancaires_etablissements (id_etablissement, id_type_mouvement, montant, date_mouvement) VALUES
(1, 1, 100000.00, '2024-01-15'),
(1, 4, -15000.00, '2024-01-20'),
(1, 5, 2500.00, '2024-01-31'),
(2, 1, 75000.00, '2024-01-10'),
(2, 4, -8000.00, '2024-01-25'),
(3, 1, 50000.00, '2024-01-12'),
(3, 4, -25000.00, '2024-01-18');

-- Insertion des types de remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle) VALUES
('Mensuel', 12),
('Trimestriel', 4),
('Semestriel', 2),
('Annuel', 1);

-- Insertion des types de prêts
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif) VALUES
('Prêt personnel', 3.00, 8.00, 'Financement personnel'),
('Prêt auto', 2.50, 6.50, 'Achat véhicule'),
('Prêt immobilier', 1.50, 4.00, 'Achat immobilier'),
('Prêt travaux', 2.00, 7.00, 'Rénovation'),
('Prêt étudiant', 1.00, 3.00, 'Études');

-- Insertion des contrats de prêts
INSERT INTO EF_contrats_prets (id_client, id_type_remboursement, uuid, id_type_pret, taux_interet_annuel, taux_assurance_annuel, duree_remboursement_mois, montant_pret, montant_echeance) VALUES
(1, 1, 'a1b2c3d4-e5f6-7890-abcd-ef1234567890', 2, 4.50, 0.50, 60, 15000.00, 285.50),
(2, 1, 'b2c3d4e5-f6g7-8901-bcde-f23456789012', 1, 6.00, 0.75, 36, 8000.00, 248.20),
(3, 2, 'c3d4e5f6-g7h8-9012-cdef-345678901234', 4, 5.50, 0.60, 48, 25000.00, 1587.50),
(4, 1, 'd4e5f6g7-h8i9-0123-defg-456789012345', 1, 7.20, 0.80, 24, 5000.00, 235.15),
(5, 1, 'e5f6g7h8-i9j0-1234-efgh-567890123456', 3, 3.20, 0.40, 240, 180000.00, 928.75);

-- Insertion des statuts de contrat
INSERT INTO EF_status_contrat (libelle) VALUES
('Actif'),
('Terminé'),
('Suspendu'),
('Annulé'),
('En attente');

-- Insertion des mouvements de statuts de contrat
INSERT INTO EF_mouvement_status_contrat (id_contrat_pret, id_status_contrat, date_mouvement) VALUES
(1, 1, '2023-06-15'),
(2, 1, '2023-09-10'),
(3, 1, '2023-04-20'),
(4, 1, '2024-01-05'),
(5, 1, '2022-03-12'),
-- Quelques changements de statut
(2, 3, '2024-01-15'), -- Suspension temporaire
(2, 1, '2024-02-01');  -- Réactivation

-- Insertion des prêts clients
INSERT INTO EF_prets_clients (id_contrat_pret, montant_pret, montant_total_a_rembourser, nombre_periodes, montant_echeance_periodique, montant_assurance_periodique, date_debut_pret, date_fin_prevue_pret) VALUES
(1, 15000.00, 17130.00, 60, 280.19, 5.31, '2023-06-20', '2028-06-20'),
(2, 8000.00, 8935.20, 36, 243.15, 5.05, '2023-09-15', '2026-09-15'),
(3, 25000.00, 31750.00, 16, 1521.88, 65.62, '2023-04-25', '2027-04-25'),
(4, 5000.00, 5643.60, 24, 228.89, 6.26, '2024-01-10', '2026-01-10'),
(5, 180000.00, 222900.00, 240, 890.45, 38.30, '2022-03-15', '2042-03-15');

-- Insertion des remboursements (exemples pour les premiers mois)
INSERT INTO EF_remboursements_prets (id_pret_client, numero_periode, date_remboursement, montant_echeance, montant_interet, montant_assurance, montant_capital_rembourse, capital_restant_du) VALUES
-- Prêt 1 (Client 1)
(1, 1, '2023-07-20', 285.50, 56.25, 6.25, 223.00, 14777.00),
(1, 2, '2023-08-20', 285.50, 55.41, 6.25, 223.84, 14553.16),
(1, 3, '2023-09-20', 285.50, 54.57, 6.25, 224.68, 14328.48),
(1, 4, NULL, 285.50, 53.73, 6.25, 225.52, 14102.96),
(1, 5, NULL, 285.50, 52.89, 6.25, 226.36, 13876.60),
-- Prêt 2 (Client 2)
(2, 1, '2023-10-15', 248.20, 40.00, 5.00, 203.20, 7796.80),
(2, 2, '2023-11-15', 248.20, 38.98, 5.00, 204.22, 7592.58),
(2, 3, NULL, 248.20, 37.96, 5.00, 205.24, 7387.34),
-- Prêt 3 (Client 3) - Remboursement trimestriel
(3, 1, '2023-07-25', 1587.50, 343.75, 62.50, 1181.25, 23818.75),
(3, 2, NULL, 1587.50, 327.26, 62.50, 1197.74, 22621.01),
-- Prêt 4 (Client 4)
(4, 1, '2024-02-10', 235.15, 30.00, 6.25, 198.90, 4801.10),
(4, 2, NULL, 235.15, 28.81, 6.25, 200.09, 4601.01),
-- Prêt 5 (Client 5)
(5, 1, '2022-04-15', 928.75, 480.00, 60.00, 388.75, 179611.25),
(5, 2, '2022-05-15', 928.75, 478.96, 60.00, 389.79, 179221.46),
(5, 3, '2022-06-15', 928.75, 477.91, 60.00, 390.84, 178830.62);

-- Insertion des types de partenaires
INSERT INTO EF_type_partenaire (description) VALUES
('Banque partenaire'),
('Société de gestion'),
('Courtier en assurance'),
('Établissement de crédit'),
('Plateforme d\'investissement');

-- Insertion des partenaires
INSERT INTO EF_partenaire (id_type_partenaire, nom_partenaire, description_partenaire, commentaire) VALUES
(1, 'BNP Paribas', 'Banque de référence', 'Partenariat privilégié'),
(2, 'Amundi', 'Leader de la gestion d\'actifs', 'Fonds diversifiés'),
(3, 'AXA Investments', 'Spécialiste assurance-vie', 'Produits vie et capitalisation'),
(4, 'Société Générale', 'Banque universelle', 'Produits de financement'),
(5, 'Boursorama', 'Banque en ligne', 'Placements digitaux');

-- Insertion des mouvements partenaires
INSERT INTO EF_mouvements_partenaire (id_partenaire, date_changement, duree_maximale_jours, duree_minimale_jours, depot_minimum, depot_maximum, taux_rendement_annuel) VALUES
(1, '2024-01-01', 365, 30, 1000.00, 100000.00, 2.50),
(2, '2024-01-01', 1095, 365, 5000.00, 500000.00, 4.20),
(3, '2024-01-01', 2555, 1095, 10000.00, 1000000.00, 3.80),
(4, '2024-01-01', 730, 180, 2000.00, 200000.00, 3.20),
(5, '2024-01-01', 1825, 365, 1000.00, 50000.00, 2.80),
-- Ajout d'évolutions tarifaires
(1, '2024-03-01', 365, 30, 1000.00, 100000.00, 2.75),
(2, '2024-02-15', 1095, 365, 5000.00, 500000.00, 4.00);

-- Insertion des fonds investis par les clients
INSERT INTO EF_fonds_investis_clients (id_partenaire, id_client, montant_investi, date_investissement) VALUES
(1, 1, 5000.00, '2023-06-01'),
(2, 2, 15000.00, '2023-01-15'),
(3, 3, 25000.00, '2022-10-01'),
(4, 4, 8000.00, '2023-09-01'),
(5, 5, 12000.00, '2023-03-01'),
(1, 2, 3000.00, '2023-12-01'),
(2, 1, 10000.00, '2024-01-10'),
(3, 4, 15000.00, '2023-05-15'),
(4, 3, 5000.00, '2024-02-01'),
(5, 2, 7500.00, '2023-11-20');

-- Insertion des retraits de fonds
INSERT INTO EF_retraits_fonds (id_fond_investi, date_retrait, montant_retrait, montant_interets, motif_retrait) VALUES
(2, '2024-01-15', 15630.00, 630.00, 'Échéance normale'),
(3, '2023-12-15', 5000.00, 190.00, 'Retrait anticipé partiel'),
(4, '2024-02-01', 2000.00, 64.00, 'Besoin de trésorerie'),
(6, '2024-01-01', 3075.00, 75.00, 'Fin de placement'),
(8, '2024-01-20', 3000.00, 115.00, 'Retrait partiel'),
(1, '2024-01-31', 1500.00, 62.50, 'Retrait partiel anticipé');

-- Affichage des statistiques des données insérées
SELECT 'Résumé des données insérées (Version mise à jour) :' as Information;
SELECT 'Clients' as Table_Name, COUNT(*) as Nombre_Enregistrements FROM EF_clients
UNION ALL
SELECT 'Activités clients', COUNT(*) FROM EF_activites_clients
UNION ALL
SELECT 'Mouvements bancaires clients', COUNT(*) FROM EF_mouvements_bancaires_clients
UNION ALL
SELECT 'Établissements financiers', COUNT(*) FROM EF_etablissements_financiers
UNION ALL
SELECT 'Mouvements bancaires établissements', COUNT(*) FROM EF_mouvements_bancaires_etablissements
UNION ALL
SELECT 'Contrats prêts', COUNT(*) FROM EF_contrats_prets
UNION ALL
SELECT 'Statuts contrat', COUNT(*) FROM EF_status_contrat
UNION ALL
SELECT 'Mouvements statuts contrat', COUNT(*) FROM EF_mouvement_status_contrat
UNION ALL
SELECT 'Prêts clients', COUNT(*) FROM EF_prets_clients
UNION ALL
SELECT 'Remboursements prêts', COUNT(*) FROM EF_remboursements_prets
UNION ALL
SELECT 'Partenaires', COUNT(*) FROM EF_partenaire
UNION ALL
SELECT 'Mouvements partenaire', COUNT(*) FROM EF_mouvements_partenaire
UNION ALL
SELECT 'Fonds investis clients', COUNT(*) FROM EF_fonds_investis_clients
UNION ALL
SELECT 'Retraits fonds', COUNT(*) FROM EF_retraits_fonds;