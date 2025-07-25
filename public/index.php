<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once __DIR__ . '/../route/route.web.php';



// try {
//     $pdo = Database::getConnection();
//     echo "✅ Connexion réussie à la base de données.";
// } catch (Exception $e) {
//     echo "❌ Erreur de connexion : " . $e->getMessage();
// }
// die();

// use App\Config\Core\Router;

// // Définition des routes
// Router::$routes = [
//     "/commande" => [
//         "controller" => "App\\Controller\\CommandeController",
//         "action" => "form"
//     ],
//     "/list" => [
//         "controller" => "App\\Controller\\CommandeController",
//         "action" => "list"
//     ]
// ];

// // Appel du routeur
// Router::resolve();

//logique de gestion du routage 
// donner a chaque lien une uri 
// tableau correspondance 
// uri = controller + action 
//identidier uri et le mapper au controlleur et l'action a executer tableau (routage)
// tableau met en relation uri contoller et action 
// fonction resolve qui defini le tableau ecris lalgo qui recupere l'uri si rien list


//nom communs des functions pour le controller index,store,show,create,edit,destroy
// index = list
// store = form
// show = facture
// create = form
// edit = form
// destroy = delete

// creer abstract controller dans core avec ces methodes


//Apporter listes des commandes chargés dynamiquement a rendre demain sinon wann di na niou ray !!
//in
//integrer page de conncexion controller securityController qui le charge
// layout le code commun entre plusieurs pages 


// a faire lundi fichier env (url d'authentification) driver,si je change la cle a mysql je bascule dans mysql et si je change la cle a sqlite je bascule dans sqlite et si je change la cle a postgresql je bascule dans postgresql on declare une variable http://localhost:8000 documentation sur les methode magique des classes en php la reflexion en php instancier sans new continuer connexion session affichage de la liste des commandes