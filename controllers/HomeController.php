<?php

class HomeController extends Controller
{
    private $pageTpl = '/views/home.tpl.php';

    public function __construct()
    {
        parent::__construct();
        $this->model = new HomeModel();
        $this->view = new View();
    }

    public function index()
    {
        $this->model->securityCheck();
        $this->pageData['title'] = "Главная";
        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function getContent() {
        try {
            $url = 'http://jsonplaceholder.typicode.com/posts/'.$_GET['page'];;
            $response = file_get_contents($url);
            if ($response !== false) {
                echo $response;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function saveContent() {
        try {
            $records = $_POST['data'];
            foreach ($records as $record) {
                $sql = "INSERT INTO data (title, body, user, button)
                        VALUES (:title, :body, :user, :button)";
                $this->db = DB::connToMYSQL();
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(":title", $record[0], PDO::PARAM_STR);
                $stmt->bindValue(":body", $record[1], PDO::PARAM_STR);
                $stmt->bindValue(":user", $record[2], PDO::PARAM_STR);
                $stmt->bindValue(":button", $record[3], PDO::PARAM_STR);
                $stmt->execute();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}