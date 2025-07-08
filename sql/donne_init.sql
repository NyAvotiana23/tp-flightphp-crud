-- Insert data into EF_type_partenaire
INSERT INTO EF_type_partenaire (designation) VALUES
                                                 ('Fonds d''investissement'),
                                                 ('Banque partenaire'),
                                                 ('Société de capital-risque');

-- Insert data into EF_partenaire
INSERT INTO EF_partenaire (id_type_partenaire, nom_partenaire, description_partenaire, commentaire) VALUES
                                                                                                        (1, 'Fonds Alpha', 'Fonds spécialisé dans les startups tech', 'Fiable et performant'),
                                                                                                        (2, 'Banque Beta', 'Banque offrant des produits d''investissement', 'Partenariat long terme'),
                                                                                                        (3, 'Capital Gamma', 'Société de capital-risque', 'Focus sur l''innovation');

-- Insert data into EF_status_contrat
INSERT INTO EF_status_contrat (libelle) VALUES
                                            ('En attente'),
                                            ('Validé'),
                                            ('Refusé');

-- Insert data into EF_types_prets
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif) VALUES
                                                                                                        ('Prêt personnel', 3.50, 7.00, 'Financement de projets personnels'),
                                                                                                        ('Prêt immobilier', 2.00, 4.50, 'Achat de biens immobiliers'),
                                                                                                        ('Prêt professionnel', 4.00, 8.00, 'Développement d''activités professionnelles');

-- Insert data into EF_types_remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle) VALUES
                                                                                      ('Mensuel', 12),
                                                                                      ('Trimestriel', 4),
                                                                                      ('Annuel', 1);

-- Insert data into EF_types_mouvements_etablissements
INSERT INTO EF_types_mouvements_etablissements (nom_type_mouvement) VALUES
                                                                        ('Gain Fond'),
                                                                        ('Retour Fond'),
                                                                        ('Sortie Prêt'),
                                                                        ('Remboursement Prêt');

-- Insert data into EF_etablissements_financiers
INSERT INTO EF_etablissements_financiers (numero_identification, mot_de_passe, nom_etablissement, adresse_etablissement, telephone, commentaire) VALUES
                                                                                                                                                     ('EF001', '$2a$10$hashedpassword1', 'Banque Centrale', '123 Rue Finance, Paris', '0123456789', 'Établissement principal'),
                                                                                                                                                     ('EF002', '$2a$10$hashedpassword2', 'Crédit Mutual', '456 Avenue Banque, Lyon', '0987654321', 'Partenaire régional');

-- Insert data into EF_types_mouvements_bancaires
INSERT INTO EF_types_mouvements_bancaires (nom_type_mouvement, description) VALUES
                                                                                ('Fond investissement', 'Investissement dans un fonds partenaire'),
                                                                                ('Prêt', 'Réception d''un prêt'),
                                                                                ('Remboursement Prêt', 'Remboursement d''une échéance de prêt'),
                                                                                ('Activité', 'Revenus issus d''une activité'),
                                                                                ('Budget Initial', 'Dépôt initial sur le compte'),
                                                                                ('Autres', 'Autres mouvements financiers');

-- Insert data into EF_types_contrats_activite
INSERT INTO EF_types_contrats_activite (nom_type_contrat, description) VALUES
                                                                           ('CDI', 'Contrat à durée indéterminée'),
                                                                           ('CDD', 'Contrat à durée déterminée'),
                                                                           ('Freelance', 'Activité indépendante');

-- Insert data into EF_clients
INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone) VALUES
                                                                                                                 ('CL001', '$2a$10$hashedpassword3', 'Dupont', 'Jean', '1985-03-15', 'jean.dupont@example.com', '10 Rue Liberté, Paris', '0612345678'),
                                                                                                                 ('CL002', '$2a$10$hashedpassword4', 'Martin', 'Sophie', '1990-07-22', 'sophie.martin@example.com', '20 Avenue Paix, Lyon', '0698765432'),
                                                                                                                 ('CL003', '$2a$10$hashedpassword5', 'Lefevre', 'Paul', '1978-11-10', 'paul.lefevre@example.com', '30 Boulevard Justice, Marseille', '0623456789');

-- Insert data into EF_activites_clients
INSERT INTO EF_activites_clients (id_client, id_type_contrat, nom_activite, revenu_net_mensuel, date_debut, date_fin) VALUES
                                                                                                                          (1, 1, 'Ingénieur logiciel', 3500.00, '2020-01-01', NULL),
                                                                                                                          (2, 3, 'Graphiste freelance', 2500.00, '2022-06-01', NULL),
                                                                                                                          (3, 2, 'Consultant marketing', 3000.00, '2023-03-01', '2025-03-01');

-- Insert initial funds into EF_mouvements_bancaires_clients (Budget Initial to ensure clients have funds)
INSERT INTO EF_mouvements_bancaires_clients (id_client, id_type_mouvement, date_mouvement, montant) VALUES
                                                                                                        (1, 5, '2025-01-01', 50000.00), -- Client 1: Budget Initial
                                                                                                        (2, 5, '2025-01-01', 30000.00), -- Client 2: Budget Initial
                                                                                                        (3, 5, '2025-01-01', 40000.00); -- Client 3: Budget Initial

-- Insert investment movements into EF_mouvements_bancaires_clients (Fond investissement, negative for clients)
INSERT INTO EF_mouvements_bancaires_clients (id_client, id_type_mouvement, date_mouvement, montant) VALUES
                                                                                                        (1, 1, '2025-02-01', -10000.00), -- Client 1 invests 10,000
                                                                                                        (2, 1, '2025-02-15', -5000.00),  -- Client 2 invests 5,000
                                                                                                        (3, 1, '2025-03-01', -8000.00);  -- Client 3 invests 8,000

-- Insert data into EF_mouvements_partenaire
INSERT INTO EF_mouvements_partenaire (id_partenaire, date_changement, duree_maximale_jours, duree_minimale_jours, depot_minimum, depot_maximum, taux_rendement_annuel) VALUES
                                                                                                                                                                           (1, '2025-01-01', 730, 90, 1000.00, 100000.00, 5.00),
                                                                                                                                                                           (2, '2025-01-01', 365, 30, 500.00, 50000.00, 3.50),
                                                                                                                                                                           (3, '2025-01-01', 1095, 180, 2000.00, 200000.00, 6.00);

-- Insert data into EF_fonds_investis_clients
INSERT INTO EF_fonds_investis_clients (id_partenaire, id_client, montant_investi, date_investissement) VALUES
                                                                                                           (1, 1, 10000.00, '2025-02-01'), -- Corresponds to Client 1's investment
                                                                                                           (2, 2, 5000.00, '2025-02-15'),  -- Corresponds to Client 2's investment
                                                                                                           (3, 3, 8000.00, '2025-03-01');  -- Corresponds to Client 3's investment

-- Insert corresponding movements into EF_mouvements_bancaires_etablissements (Gain Fond, positive for EF)
INSERT INTO EF_mouvements_bancaires_etablissements (id_etablissement, id_type_mouvement, montant, date_mouvement) VALUES
                                                                                                                      (1, 1, 10000.00, '2025-02-01'), -- Corresponds to Client 1's investment
                                                                                                                      (1, 1, 5000.00, '2025-02-15'),  -- Corresponds to Client 2's investment
                                                                                                                      (2, 1, 8000.00, '2025-03-01');  -- Corresponds to Client 3's investment