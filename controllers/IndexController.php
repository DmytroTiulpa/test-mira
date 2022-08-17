<?php

class IndexController extends Controller
{
    private $pageTpl = '/views/index.tpl.php';

    public function __construct()
    {
        parent::__construct();
        $this->model = new IndexModel();
        $this->view = new View();
    }

    public function index()
    {
        $this->pageData['title'] = "Вход";

        if (!empty($_POST)) {
            if (!$this->login()) {
                $this->pageData['error'] = "Неверный логин или пароль";
            }
        }

        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function login() {
        if(!$this->model->checkUser()) {
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }

}