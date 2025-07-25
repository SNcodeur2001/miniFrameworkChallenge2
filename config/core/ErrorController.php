<?php
namespace App\Controller;

class ErrorController {
    
    public function notFound() {
        require_once '../template/commande/404.php';
    }

    
}