<?php

namespace App\Config\Core;
use App\Config\Core\Session;


abstract class AbstractController
{
    protected string $layout = 'base.layout.php';
    protected Session $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }

    abstract public function index();

    abstract public function store();

    abstract public function create();


    abstract public function destroy();

    abstract public function show();

    abstract public function edit();



    protected function renderHtml(String $view, array $params = [])
    {
        extract($params);

        ob_start();
        require_once '../template/' . $view;
        $contentForLayout = ob_get_clean();

        require_once '../template/layout/' . $this->layout;
    }









    // protected function renderHtml(String $view, array $params = [])
    // {
    //     extract($params);

    //     ob_start();
    //     require_once '../template/' . $view;
    //     $contentForLayout = ob_get_clean();

    //     require_once '../template/layout/base.layout.php';
    // }

    // protected function renderHtmlLogin(String $view)
    // {
    //     require_once '../template/' . $view;
    // }
}
