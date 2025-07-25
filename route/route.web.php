<?php

use App\Config\Core\Router;
use App\Controller\CommandeController;
use App\Controller\FactureController;
use App\Controller\SecurityController;

// Routes de sécurité (pas de middleware)
Router::get('/', SecurityController::class, 'index');
Router::post('/login', SecurityController::class, 'login');
Router::post('/authenticate', SecurityController::class, 'authenticate');
Router::get('/logout', SecurityController::class, 'logout');

// Routes des commandes (protégées par middleware 'auth')
Router::get('/list', CommandeController::class, 'index', ['auth']);
Router::get('/facture', FactureController::class, 'show', ['auth']);
Router::get('/form', CommandeController::class, 'create', ['auth', 'isVendeur']);

// Résoudre la route
Router::resolve();
