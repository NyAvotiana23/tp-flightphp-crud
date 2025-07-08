-- Insert data for EF_type_partenaire
INSERT INTO EF_type_partenaire (designation) VALUES
                                                 ('Banque'),
                                                 ('Fond d''investissement'),
                                                 ('Coopérative');

-- Insert data for EF_partenaire
INSERT INTO EF_partenaire (id_type_partenaire, nom_partenaire, description_partenaire, commentaire) VALUES
                                                                                                        (1, 'Banque Nationale', 'Banque commerciale principale', 'Partenaire fiable depuis 10 ans'),
                                                                                                        (2, 'Fond Alpha', 'Fond d''investissement spécialisé en startups', 'Haut rendement potentiel'),
                                                                                                        (3, 'Coopérative Locale', 'Coopérative de microcrédit', 'Soutien aux petites entreprises');

-- Insert data for EF_status_contrat
INSERT INTO EF_status_contrat (libelle) VALUES
                                            ('en_attente'),
                                            ('valider'),
                                            ('refuser');

-- Insert data for EF_types_prets
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif) VALUES
                                                                                                        ('Prêt personnel', 3.50, 7.00, 'Financement de projets personnels'),
                                                                                                        ('Prêt immobilier', 2.00, 4.50, 'Achat de biens immobiliers'),
                                                                                                        ('Microcrédit', 5.00, 10.00, 'Soutien aux petites entreprises');

-- Insert data for EF_types_remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle) VALUES
                                                                                      ('mensuel', 12),
                                                                                      ('trimestriel', 4),
                                                                                      ('annuel', 1);

-- Insert data for EF_types_mouvements_etablissements
INSERT INTO EF_types_mouvements_etablissements (nom_type_mouvement) VALUES
                                                                        ('Gain Fond'),
                                                                        ('Retour Fond'),
                                                                        ('Sortis Pret'),
                                                                        ('Rembourssement Pret');

-- Insert data for EF_etablissements_financiers
INSERT INTO EF_etablissements_financiers (numero_identification, mot_de_passe, nom_etablissement, adresse_etablissement, telephone, commentaire) VALUES
                                                                                                                                                     ('BNK001', 'hashed_password1', 'Banque Centrale', '123 Rue Principale, Paris', '+33123456789', 'Établissement principal'),
                                                                                                                                                     ('FND001', 'hashed_password2', 'Fond Beta', '456 Avenue des Champs, Lyon', '+33456789012', 'Spécialisé en investissements'),
                                                                                                                                                     ('COOP001', 'hashed_password3', 'Coopérative Nord', '789 Boulevard Sud, Marseille', '+33987654321', 'Microcrédit local');

-- Insert data for EF_types_mouvements_bancaires
INSERT INTO EF_types_mouvements_bancaires (nom_type_mouvement, description) VALUES
                                                                                ('Fond investissement', 'Investissement dans un fond'),
                                                                                ('Pret', 'Octroi d''un prêt'),
                                                                                ('Rembourssement Pret', 'Remboursement d''un prêt'),
                                                                                ('Activite', 'Revenus d''une activité'),
                                                                                ('Budget Initial', 'Dépôt initial'),
                                                                                ('Autres', 'Autres mouvements bancaires');

-- Insert data for EF_types_contrats_activite
INSERT INTO EF_types_contrats_activite (nom_type_contrat, description) VALUES
                                                                           ('CDI', 'Contrat à durée indéterminée'),
                                                                           ('CDD', 'Contrat à durée déterminée'),
                                                                           ('Freelance', 'Activité indépendante');

-- Insert data for EF_clients
INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone) VALUES
                                                                                                                 ('CL001', 'hashed_password_client1', 'Dupont', 'Jean', '1985-03-15', 'jean.dupont@email.com', '10 Rue de la Paix, Paris', '+33612345678'),
                                                                                                                 ('CL002', 'hashed_password_client2', 'Martin', 'Sophie', '1990-07-22', 'sophie.martin@email.com', '20 Avenue Victor Hugo, Lyon', '+33687654321'),
                                                                                                                 ('CL003', 'hashed_password_client3', 'Lefèvre', 'Pierre', '1978-11-30', 'pierre.lefevre@email.com', '30 Boulevard des Lilas, Marseille', '+33623456789');

-- Insert data for EF_activites_clients
INSERT INTO EF_activites_clients (id_client, id_type_contrat, nom_activite, revenu_net_mensuel, date_debut, date_fin) VALUES
                                                                                                                          (1, 1, 'Ingénieur logiciel', 3500.00, '2020-01-01', NULL),
                                                                                                                          (2, 3, 'Graphiste freelance', 2500.00, '2021-06-01', NULL),
                                                                                                                          (3, 2, 'Vendeur', 1800.00, '2022-03-01', '2023-03-01');

-- Insert data for EF_fonds_investis_clients
INSERT INTO EF_fonds_investis_clients (id_partenaire, id_client, montant_investi, date_investissement) VALUES
                                                                                                           (1, 1, 10000.00, '2025-01-01'),
                                                                                                           (2, 2, 5000.00, '2025-02-01'),
                                                                                                           (3, 3, 3000.00, '2025-03-01');

-- Insert data for EF_mouvements_bancaires_etablissements (only Gain Fond)
INSERT INTO EF_mouvements_bancaires_etablissements (id_etablissement, id_type_mouvement, montant, date_mouvement) VALUES
                                                                                                                      (1, 1, 10000.00, '2025-01-01'),
                                                                                                                      (2, 1, 5000.00, '2025-02-01'),
                                                                                                                      (3, 1, 3000.00, '2025-03-01');