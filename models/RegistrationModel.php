<?php

class RegistrationModel extends Model
{
    /**
     * Проверка почты на валидность
     * @param $email
     * @return bool
     */
    /*public function checkEmail($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Адрес указан корректно.";
            return true;
        }else{
            echo "Адрес указан не правильно.";
            return false;
        }
    }*/

    //TODO 3 символа после собачки - какая-то фигня
    public function checkEmail2($email)
    {
        $parts = explode('@', $email);
        if ( mb_strlen($parts[0]) < 3 ) {
            return "Почта должна содержать минимум 3 символа до собачки";
        }
        /*if ( mb_strlen($parts[1]) != 3 ) {
            return "Почта должна содержать строго 3 символа после собачки";
        }*/
    }

    /**
     * Проверка паролей на совпадение
     * @param $password
     * @param $password2
     * @return bool
     */
    public function checkPassword($password, $password2): bool
    {
        if ($password != $password2) {
            return false;
        } else {
            return true;
        }
    }

    public function checkPassword2($password)
    {
        if (mb_strlen($password) < 6) {
            return "Пароль должен содержать минимум 6 символов";
        }
    }

    public function checkPassword3($password)
    {
        if (strrpos($password, '!') === false ) {
            return "Пароль должен содержать символ !";
        }
    }

    public function registerNewUser()
    {
        $position = $_POST['position'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $sql = "INSERT INTO users (position, email, password) 
                    VALUES (:position, :email, :password)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":position", $position, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
