<?php

class RegistrationController extends Controller
{
    private $pageTpl = '/views/registration.tpl.php';

    public function __construct()
    {
        parent::__construct();
        $this->model = new RegistrationModel();
        $this->view = new View();
    }

    public function index()
    {
        $this->pageData['title'] = "Регистрация пользователя";

        if (!empty($_POST)) {

            /*echo "<pre>";
            var_dump($_POST);
            echo "</pre>";*/

            $position = $_POST['position'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $checkEmail2 = $this->model->checkEmail2($email);
            if ($checkEmail2) {
                $this->pageData['error'][] = $checkEmail2;
            }

            $checkPassword = $this->model->checkPassword($password, $password2);
            if ($checkPassword == false) {
                $this->pageData['error'][] = "Пароли не совпадают";
            }

            $checkPassword2 = $this->model->checkPassword2($password);
            if ($checkPassword2) {
                $this->pageData['error'][] = $checkPassword2;
            }

            $checkPassword3 = $this->model->checkPassword3($password);
            if ($checkPassword3) {
                $this->pageData['error'][] = $checkPassword3;
            }

            if (empty($this->pageData['error'])) {
                $registration = $this->model->registerNewUser();

                if ($registration == true) {
                header("Location: /registration/successful");
                } else {
                    $this->pageData['error'][] = "При регистрации произошла ошибка";
                }
            }

        }

        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function successful()
    {
        $this->pageTpl = '/views/successful.tpl.php';

        $this->pageData['title'] = "Новый пользователь зарегистрирован";
        $this->pageData['message'] = "Новый пользователь зарегистрирован";

        $this->view->render($this->pageTpl, $this->pageData);
    }
}
