INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone)
VALUES ('CL001', 'hashed_password1', 'Dupont', 'Jean', '1980-05-15', 'jean.dupont@example.com',
        '123 Rue de Paris, Paris', '0123456789'),
       ('CL002', 'hashed_password2', 'Martin', 'Sophie', '1990-03-22', 'sophie.martin@example.com',
        '456 Avenue de Lyon, Lyon', '0987654321'),
       ('CL003', 'hashed_password3', 'Lefevre', 'Pierre', '1975-11-30', 'pierre.lefevre@example.com',
        '789 Boulevard de Marseille, Marseille', '0678901234');

-- Insert test data into EF_types_prets
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif)
VALUES ('Immobilier', 2.5, 4.0, 'Prêt pour achat immobilier'),
       ('Consommation', 5.0, 7.0, 'Prêt pour besoins personnels'),
       ('Investissement', 3.0, 5.5, 'Prêt pour investissement professionnel');

-- Insert test data into EF_types_remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle)
VALUES ('Mensuel', 12),
       ('Trimestriel', 4),
       ('Annuel', 1);

-- Insert test data into EF_status_contrat
INSERT INTO EF_status_contrat (libelle)
VALUES ('En attente'),
       ('Validé'),
       ('Refusé');

-- Insert test data into EF_contrats_prets
INSERT INTO EF_contrats_prets (id_client, id_type_remboursement, uuid, id_type_pret, taux_interet_annuel,
                               taux_assurance_annuel, duree_remboursement_mois, montant_pret, montant_echeance)
VALUES (1, 1, 'abc123-def456-ghi789-jkl012', 1, 3.0, 0.5, 60, 100000.00, 1841.67), -- Jean Dupont, Immobilier, Mensuel
       (2, 2, 'mno123-pqr456-stu789-vwx012', 2, 6.0, 0.7, 36, 5000.00,
        152.78),                                                                   -- Sophie Martin, Consommation, Trimestriel
       (3, 3, 'xyz123-abc456-def789-ghi012', 3, 4.5, 0.3, 12, 20000.00, 1717.67);
-- Pierre Lefevre, Investissement, Annuel

-- Insert test data into EF_prets_clients
INSERT INTO EF_prets_clients (id_contrat_pret, montant_pret, montant_total_a_rembourser, nombre_periodes,
                              montant_echeance_periodique, montant_assurance_periodique, date_debut_pret,
                              date_fin_prevue_pret)
VALUES (1, 100000.00, 110500.00, 60, 1800.00, 41.67, '2025-01-01', '2030-01-01'), -- Jean Dupont
       (2, 5000.00, 5500.00, 12, 150.00, 2.78, '2025-02-01', '2026-02-01'),       -- Sophie Martin
       (3, 20000.00, 20600.00, 1, 1717.67, 5.00, '2025-03-01', '2026-03-01');
-- Pierre Lefevre

-- Insert test data into EF/remboursements_prets
INSERT INTO EF_remboursements_prets (id_pret_client, numero_periode, date_remboursement, montant_echeance,
                                     montant_interet, montant_assurance, montant_capital_rembourse, capital_restant_du)
VALUES (1, 1, '2025-02-01', 1800.00, 250.00, 41.67, 1508.33, 98491.67), -- Jean Dupont, 1st repayment
       (1, 2, '2025-03-01', 1800.00, 246.23, 41.67, 1512.10, 96979.57), -- Jean Dupont, 2nd repayment
       (2, 1, '2025-05-01', 150.00, 12.50, 2.78, 134.72, 4865.28),      -- Sophie Martin, 1st repayment
       (3, 1, NULL, 1717.67, 75.00, 5.00, 1637.67, 18362.33);
-- Pierre Lefevre, not yet paid

-- Insert test data into EF_mouvement_status_contrat
INSERT INTO EF_mouvement_status_contrat (id_contrat_pret, id_status_contrat, date_mouvement)
VALUES (1, 2, '2025-01-01'), -- Jean Dupont, Validé
       (2, 1, '2025-02-01'), -- Sophie Martin, En attente
       (3, 3, '2025-03-01'); -- Pierre Lefevre, Refusé
