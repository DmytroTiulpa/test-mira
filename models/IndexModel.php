<?php

class IndexModel extends Model
{
    /**
     * Проверка пользователя
     * @return PDO|null
     */
    public function checkUser()
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);

        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        if (!empty($result)) {
            $this->startSession($result);
            header("Location: /home");
        } else {
            // не зарегистрирован
        }
    }

}
