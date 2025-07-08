-- 1. EF_types_contrats_activite
INSERT INTO EF_types_contrats_activite (nom_type_contrat, description)
VALUES ('CDI', 'Contrat à durée indéterminée'),
       ('CDD', 'Contrat à durée déterminée'),
       ('Freelance', 'Activité indépendante'),
       ('Stage', 'Contrat de stage professionnel');

-- 2. EF_clients
INSERT INTO EF_clients (numero_client, mot_de_passe, nom, prenom, date_naissance, email, adresse, telephone)
VALUES ('CLT001', 'hashed_password_1', 'Dupont', 'Jean', '1985-03-15', 'jean.dupont@email.com',
        '12 Rue de Paris, 75001 Paris', '0123456789'),
       ('CLT002', 'hashed_password_2', 'Martin', 'Sophie', '1990-07-22', 'sophie.martin@email.com',
        '45 Avenue des Lilas, 69001 Lyon', '0987654321'),
       ('CLT003', 'hashed_password_3', 'Leroy', 'Paul', '1978-11-30', 'paul.leroy@email.com',
        '8 Boulevard Voltaire, 31000 Toulouse', '0678901234'),
       ('CLT004', 'hashed_password_4', 'Moreau', 'Claire', '1995-01-10', 'claire.moreau@email.com',
        '22 Rue du Commerce, 44000 Nantes', '0612345678');

-- 3. EF_types_mouvements_bancaires
INSERT INTO EF_types_mouvements_bancaires (nom_type_mouvement, description)
VALUES ('Dépôt', 'Dépôt d’argent sur le compte client'),
       ('Retrait', 'Retrait d’argent du compte client'),
       ('Virement', 'Transfert d’argent vers un autre compte'),
       ('Paiement', 'Paiement effectué par le client');

-- 4. EF_etablissements_financiers
INSERT INTO EF_etablissements_financiers (numero_identification, mot_de_passe, nom_etablissement, adresse_etablissement,
                                          telephone, commentaire)
VALUES ('ETB001', 'hashed_password_etb1', 'Banque Nationale', '100 Avenue des Champs-Élysées, 75008 Paris',
        '0145678901', 'Banque principale avec services complets'),
       ('ETB002', 'hashed_password_etb2', 'Crédit Local', '50 Rue de la République, 69002 Lyon', '0478901234',
        'Banque régionale'),
       ('ETB003', 'hashed_password_etb3', 'Finance Plus', '30 Boulevard des Capucines, 33000 Bordeaux', '0556789012',
        'Spécialisée dans les prêts');

-- 5. EF_types_mouvements_etablissements
INSERT INTO EF_types_mouvements_etablissements (nom_type_mouvement)
VALUES ('Transfert Interne', 'Transfert entre comptes de l’établissement'),
       ('Prêt Accordé', 'Octroi d’un prêt à un client'),
       ('Remboursement Reçu', 'Remboursement d’un prêt par un client'),
       ('Investissement', 'Investissement dans un fonds ou partenaire');

-- 6. EF_types_remboursements
INSERT INTO EF_types_remboursements (nom_type_remboursement, repetition_annuelle)
VALUES ('Mensuel', 12),
       ('Trimestriel', 4),
       ('Semestriel', 2),
       ('Annuel', 1);

-- 7. EF_types_prets
INSERT INTO EF_types_prets (nom_type_pret, taux_interet_min_annuel, taux_interet_max_annuel, motif)
VALUES ('Prêt Personnel', 3.50, 7.00, 'Prêt pour besoins personnels'),
       ('Prêt Immobilier', 1.50, 3.50, 'Financement d’achat immobilier'),
       ('Prêt Auto', 2.50, 5.00, 'Achat d’un véhicule'),
       ('Prêt Étudiant', 1.00, 2.50, 'Financement des études');

-- 8. EF_status_contrat
INSERT INTO EF_status_contrat (libelle)
VALUES ('En attente'),
       ('Actif'),
       ('Terminé'),
       ('Annulé'),
       ('En défaut');

-- 9. EF_type_partenaire
INSERT INTO EF_type_partenaire (designation)
VALUES ('Fonds d’investissement'),
       ('Banque partenaire'),
       ('Assurance'),
       ('Société de gestion');

-- 10. EF_partenaire
INSERT INTO EF_partenaire (id_type_partenaire, nom_partenaire, description_partenaire, commentaire)
VALUES (1, 'InvestCorp', 'Fonds d’investissement spécialisé en actions',
        'Partenaire fiable pour investissements long terme'),
       (2, 'Banque Partner', 'Banque partenaire pour prêts et dépôts', 'Collaboration pour services bancaires'),
       (3, 'AssurPlus', 'Compagnie d’assurance pour prêts', 'Fournit des assurances pour prêts'),
       (4, 'Gestion Actifs SA', 'Société de gestion de portefeuilles', 'Gestion d’actifs pour clients');