<?php

require_once __DIR__ . '/../controllers/ClientController.php';
require_once __DIR__ . '/../controllers/TypeContratActiviteController.php';
require_once __DIR__ . '/../controllers/ActiviteClientController.php';
require_once __DIR__ . '/../controllers/TypeMouvementBancaireController.php';
require_once __DIR__ . '/../controllers/MouvementBancaireClientController.php';
require_once __DIR__ . '/../controllers/TypeMouvementEtablissementController.php';
require_once __DIR__ . '/../controllers/MouvementBancaireEtablissementController.php';
require_once __DIR__ . '/../controllers/TypeRemboursementController.php';
require_once __DIR__ . '/../controllers/TypePretController.php';
require_once __DIR__ . '/../controllers/ContratPretController.php';
require_once __DIR__ . '/../controllers/PretClientController.php';
require_once __DIR__ . '/../controllers/RemboursementPretController.php';
require_once __DIR__ . '/../controllers/TypeFondController.php';
require_once __DIR__ . '/../controllers/ProduitInvestissementController.php';
require_once __DIR__ . '/../controllers/MouvementPartenaireController.php';
require_once __DIR__ . '/../controllers/FondInvestiClientController.php';
require_once __DIR__ . '/../controllers/RetraitFondController.php';
require_once __DIR__ . '/../controllers/EtudiantController.php';

// Clients
Flight::route('GET /clients', ['ClientController', 'getAll']);
Flight::route('GET /clients/@id', ['ClientController', 'getById']);
Flight::route('POST /clients', ['ClientController', 'create']);
Flight::route('PUT /clients/@id', ['ClientController', 'update']);
Flight::route('DELETE /clients/@id', ['ClientController', 'delete']);

// Types de contrats d'activité
Flight::route('GET /types-contrats-activite', ['TypeContratActiviteController', 'getAll']);
Flight::route('GET /types-contrats-activite/@id', ['TypeContratActiviteController', 'getById']);
Flight::route('POST /types-contrats-activite', ['TypeContratActiviteController', 'create']);
Flight::route('PUT /types-contrats-activite/@id', ['TypeContratActiviteController', 'update']);
Flight::route('DELETE /types-contrats-activite/@id', ['TypeContratActiviteController', 'delete']);

// Activités des clients
Flight::route('GET /activites-clients', ['ActiviteClientController', 'getAll']);
Flight::route('GET /activites-clients/@id', ['ActiviteClientController', 'getById']);
Flight::route('POST /activites-clients', ['ActiviteClientController', 'create']);
Flight::route('PUT /activites-clients/@id', ['ActiviteClientController', 'update']);
Flight::route('DELETE /activites-clients/@id', ['ActiviteClientController', 'delete']);

// Types de mouvements bancaires
Flight::route('GET /types-mouvements-bancaires', ['TypeMouvementBancaireController', 'getAll']);
Flight::route('GET /types-mouvements-bancaires/@id', ['TypeMouvementBancaireController', 'getById']);
Flight::route('POST /types-mouvements-bancaires', ['TypeMouvementBancaireController', 'create']);
Flight::route('PUT /types-mouvements-bancaires/@id', ['TypeMouvementBancaireController', 'update']);
Flight::route('DELETE /types-mouvements-bancaires/@id', ['TypeMouvementBancaireController', 'delete']);

// Mouvements bancaires clients
Flight::route('GET /mouvements-bancaires-clients', ['MouvementBancaireClientController', 'getAll']);
Flight::route('GET /mouvements-bancaires-clients/@id', ['MouvementBancaireClientController', 'getById']);
Flight::route('POST /mouvements-bancaires-clients', ['MouvementBancaireClientController', 'create']);
Flight::route('PUT /mouvements-bancaires-clients/@id', ['MouvementBancaireClientController', 'update']);
Flight::route('DELETE /mouvements-bancaires-clients/@id', ['MouvementBancaireClientController', 'delete']);

// Types de mouvements établissements
Flight::route('GET /types-mouvements-etablissements', ['TypeMouvementEtablissementController', 'getAll']);
Flight::route('GET /types-mouvements-etablissements/@id', ['TypeMouvementEtablissementController', 'getById']);
Flight::route('POST /types-mouvements-etablissements', ['TypeMouvementEtablissementController', 'create']);
Flight::route('PUT /types-mouvements-etablissements/@id', ['TypeMouvementEtablissementController', 'update']);
Flight::route('DELETE /types-mouvements-etablissements/@id', ['TypeMouvementEtablissementController', 'delete']);

// Mouvements bancaires établissements
Flight::route('GET /mouvements-bancaires-etablissements', ['MouvementBancaireEtablissementController', 'getAll']);
Flight::route('GET /mouvements-bancaires-etablissements/@id', ['MouvementBancaireEtablissementController', 'getById']);
Flight::route('POST /mouvements-bancaires-etablissements', ['MouvementBancaireEtablissementController', 'create']);
Flight::route('PUT /mouvements-bancaires-etablissements/@id', ['MouvementBancaireEtablissementController', 'update']);
Flight::route('DELETE /mouvements-bancaires-etablissements/@id', ['MouvementBancaireEtablissementController', 'delete']);

// Types de remboursement
Flight::route('GET /types-remboursements', ['TypeRemboursementController', 'getAll']);
Flight::route('GET /types-remboursements/@id', ['TypeRemboursementController', 'getById']);
Flight::route('POST /types-remboursements', ['TypeRemboursementController', 'create']);
Flight::route('PUT /types-remboursements/@id', ['TypeRemboursementController', 'update']);
Flight::route('DELETE /types-remboursements/@id', ['TypeRemboursementController', 'delete']);

// Types de prêt
Flight::route('GET /types-prets', ['TypePretController', 'getAll']);
Flight::route('GET /types-prets/@id', ['TypePretController', 'getById']);
Flight::route('POST /types-prets', ['TypePretController', 'create']);
Flight::route('PUT /types-prets/@id', ['TypePretController', 'update']);
Flight::route('DELETE /types-prets/@id', ['TypePretController', 'delete']);

// Contrats de prêt
Flight::route('GET /contrats-prets', ['ContratPretController', 'getAll']);
Flight::route('GET /contrats-prets/@id', ['ContratPretController', 'getById']);
Flight::route('POST /contrats-prets', ['ContratPretController', 'create']);
Flight::route('PUT /contrats-prets/@id', ['ContratPretController', 'update']);
Flight::route('DELETE /contrats-prets/@id', ['ContratPretController', 'delete']);

// Prêts clients
Flight::route('GET /prets-clients', ['PretClientController', 'getAll']);
Flight::route('GET /prets-clients/@id', ['PretClientController', 'getById']);
Flight::route('POST /prets-clients', ['PretClientController', 'create']);
Flight::route('PUT /prets-clients/@id', ['PretClientController', 'update']);
Flight::route('DELETE /prets-clients/@id', ['PretClientController', 'delete']);

// Remboursements prêts
Flight::route('GET /remboursements-prets', ['RemboursementPretController', 'getAll']);
Flight::route('GET /remboursements-prets/@id', ['RemboursementPretController', 'getById']);
Flight::route('POST /remboursements-prets', ['RemboursementPretController', 'create']);
Flight::route('PUT /remboursements-prets/@id', ['RemboursementPretController', 'update']);
Flight::route('DELETE /remboursements-prets/@id', ['RemboursementPretController', 'delete']);

// Types de fonds
Flight::route('GET /types-fonds', ['TypeFondController', 'getAll']);
Flight::route('GET /types-fonds/@id', ['TypeFondController', 'getById']);
Flight::route('POST /types-fonds', ['TypeFondController', 'create']);
Flight::route('PUT /types-fonds/@id', ['TypeFondController', 'update']);
Flight::route('DELETE /types-fonds/@id', ['TypeFondController', 'delete']);

// Produits d'investissement
Flight::route('GET /produits-investissements', ['ProduitInvestissementController', 'getAll']);
Flight::route('GET /produits-investissements/@id', ['ProduitInvestissementController', 'getById']);
Flight::route('POST /produits-investissements', ['ProduitInvestissementController', 'create']);
Flight::route('PUT /produits-investissements/@id', ['ProduitInvestissementController', 'update']);
Flight::route('DELETE /produits-investissements/@id', ['ProduitInvestissementController', 'delete']);

// Mouvements produits
Flight::route('GET /mouvements-produits', ['MouvementPartenaireController', 'getAll']);
Flight::route('GET /mouvements-produits/@id', ['MouvementPartenaireController', 'getById']);
Flight::route('POST /mouvements-produits', ['MouvementPartenaireController', 'create']);
Flight::route('PUT /mouvements-produits/@id', ['MouvementPartenaireController', 'update']);
Flight::route('DELETE /mouvements-produits/@id', ['MouvementPartenaireController', 'delete']);

// Fonds investis clients
Flight::route('GET /fonds-investis-clients', ['FondInvestiClientController', 'getAll']);
Flight::route('GET /fonds-investis-clients/@id', ['FondInvestiClientController', 'getById']);
Flight::route('POST /fonds-investis-clients', ['FondInvestiClientController', 'create']);
Flight::route('PUT /fonds-investis-clients/@id', ['FondInvestiClientController', 'update']);
Flight::route('DELETE /fonds-investis-clients/@id', ['FondInvestiClientController', 'delete']);

// Retraits fonds
Flight::route('GET /retraits-fonds', ['RetraitFondController', 'getAll']);
Flight::route('GET /retraits-fonds/@id', ['RetraitFondController', 'getById']);
Flight::route('POST /retraits-fonds', ['RetraitFondController', 'create']);
Flight::route('PUT /retraits-fonds/@id', ['RetraitFondController', 'update']);
Flight::route('DELETE /retraits-fonds/@id', ['RetraitFondController', 'delete']);

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /etudiants/@id', ['EtudiantController', 'getById']);
Flight::route('POST /etudiants', ['EtudiantController', 'create']);
Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);
