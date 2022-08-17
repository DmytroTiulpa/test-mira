<?php

class HomeModel extends Model
{
    //TODO убрать, дубль с FuelModel
    /**
     * @return array|false
     */
    public function getOrders($res)
    {
        $sql = "SELECT
                    o.ID,
                    --o.RES,
                    --r.NAME AS RESNAME,
                    o.DEPARTMENT,
                    d.NAME AS DEPARTMENTNAME,
                    o.LINE,
                    l.NAME AS LINENAME,
                    o.JOB,
                    j.NAME AS JOBNAME,
                    o.VEHICLE,
                    v.NAME AS VEHICLENAME,
                    o.FUEL,
                    f.NAME AS FUELNAME,
                    o.VOLUME,
                    o.DATA
                FROM GSM_ORDERS o
                    LEFT JOIN GSM_RES r on o.RES = r.ID
                    LEFT JOIN GSM_DEPARTMENTS d on o.DEPARTMENT = d.ID
                    LEFT JOIN GSM_LINES l on o.LINE = l.ID
                    LEFT JOIN GSM_JOBS j on o.JOB = j.ID
                    LEFT JOIN GSM_VEHICLES v on o.VEHICLE = v.ID
                    LEFT JOIN GSM_FUEL f on o.FUEL = f.ID
                WHERE r.ID = :RES
                ";
        $conn = DB::connToORACLE();
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':RES', $res);
        oci_execute($stmt);
        //return oci_fetch_assoc($stmt);
        // каждая строка из БД это ассоциативный массив
        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }
        if (isset($result)) {
            return $result;
        }
    }




    //TODO УБРАТЬ ОТСЮДА

    /*----- ДЛЯ ПРОВАЙДЕРА -----*/

    // TODO задвоилось?
    /**
     * Получение всех писем для провайдера
     * @return array
     */
    public function getAllLettersProvider()
    {
        $conn = DB::connToORACLE();
        //$result = array();
        $sql = "SELECT
                    l.id,
                    l.microtime,
                    l.provider as providerid,
                    p.provider as provider,
                    l.res as resid,
                    r.name as res,
                    to_char(l.dateStart, 'dd.mm.yyyy') as dateStart,
                    to_char(l.timeStart, 'HH24:MM') as timeStart,
                    to_char(l.dateEnd, 'dd.mm.yyyy') as dateEnd,
                    to_char(l.timeEnd, 'HH24:MM') as timeEnd,
                    l.typeOfWork,
                    l.placeOfWork,
                    l.conditionOfWork,
                    l.supervisor as supervisorid,
                    s.fullname as supervisor,
                    l.supervisorPhone,
                    l.supervisorGroup,
                    l.responsibleLift,
                    l.responsibleCrane,
                    l.brigade,
                    l.lift,
                    l.crane,
                    l.otherTech,
                    l.status,
                    l.resnum,
                    l.provnum,       
                    CASE
                        WHEN l.status = 0 THEN 'нова заявка'
                        WHEN l.status = 1 THEN 'на розгляді'
                        WHEN l.status = 2 THEN 'дозволено без відключення'
                        WHEN l.status = 3 THEN 'дозволено з відключенням'
                        WHEN l.status = 4 THEN 'відмовлено'
                    END AS statustext
                FROM letters l 
                LEFT JOIN providers p ON l.provider = p.id
                LEFT JOIN supervisors s ON l.supervisor = s.id
                LEFT JOIN res r ON l.res = r.res
                WHERE l.provider = :provider
                ORDER BY l.id DESC";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':provider', $_SESSION['userId']);
        oci_execute($stmt);

        // каждая строка из БД это ассоциативный массив
        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }

        if (isset($result)) {
            return $result;
        }

    }

    /**
     * Создание нового письма
     */
    public function createLetter()
    {
        $conn = DB::connToORACLE();

        $sql = "INSERT INTO letters 
                (microtime, 
                 res, 
                 dateStart, 
                 timeStart, 
                 dateEnd, 
                 timeEnd, 
                 typeOfWork, 
                 placeOfWork, 
                 conditionOfWork, 
                 supervisor, 
                 supervisorPhone, 
                 supervisorGroup, 
                 responsibleLift, 
                 responsibleCrane, 
                 brigade, 
                 lift, 
                 crane, 
                 otherTech, 
                 provider,
                 provnum)
                VALUES 
                (:microtime, 
                 :res, 
                 to_date(:dateStart,'yyyy-mm-dd'), 
                 to_date(:timeStart,'HH24:MI:SS'), 
                 to_date(:dateEnd,'yyyy-mm-dd'), 
                 to_date(:timeEnd,'HH24:MI:SS'), 
                 :typeOfWork, 
                 :placeOfWork, 
                 :conditionOfWork, 
                 :supervisor, 
                 :supervisorPhone, 
                 :supervisorGroup, 
                 :responsibleLift, 
                 :responsibleCrane, 
                 :brigade, 
                 :lift, 
                 :crane, 
                 :otherTech, 
                 :provider,
                 1 + (SELECT COUNT(provider) FROM letters WHERE provider = :provider))"; //при сохранении письма проставляем номер письма провайдера

        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':microtime',$_POST['microtime']);
        oci_bind_by_name($stmt, ':res',$_POST['res']);
        oci_bind_by_name($stmt, ':dateStart',$_POST['dateStart']);
        oci_bind_by_name($stmt, ':timeStart',$_POST['timeStart']);
        oci_bind_by_name($stmt, ':dateEnd',$_POST['dateEnd']);
        oci_bind_by_name($stmt, ':timeEnd',$_POST['timeEnd']);
        oci_bind_by_name($stmt, ':typeOfWork',$_POST['typeOfWork']);
        oci_bind_by_name($stmt, ':placeOfWork',$_POST['placeOfWork']);
        oci_bind_by_name($stmt, ':conditionOfWork',$_POST['conditionOfWork']);
        oci_bind_by_name($stmt, ':supervisor',$_POST['supervisor']);
        oci_bind_by_name($stmt, ':supervisorPhone',$_POST['supervisorPhone']);
        oci_bind_by_name($stmt, ':supervisorGroup',$_POST['supervisorGroup']);
        oci_bind_by_name($stmt, ':responsibleLift',$_POST['responsibleLift']);
        oci_bind_by_name($stmt, ':responsibleCrane',$_POST['responsibleCrane']);
        oci_bind_by_name($stmt, ':brigade',$_POST['brigade']);
        oci_bind_by_name($stmt, ':lift',$_POST['lift']);
        oci_bind_by_name($stmt, ':crane',$_POST['crane']);
        oci_bind_by_name($stmt, ':otherTech',$_POST['otherTech']);
        oci_bind_by_name($stmt, ':provider',$_SESSION['userId']);  //TODO $_SESSION['providerId']
        oci_execute($stmt);

        // загрузка файла на сервер
        if (isset($_FILES) && $_FILES['fileToUpload']['tmp_name'] != '') {
            // Каталог, в который мы будем принимать файл:
            $uploaddir = "./files/providers/";
            $uploadfile = $uploaddir.basename($_FILES['fileToUpload']['name']);

            // Копируем файл из каталога для временного хранения файлов:
            if (copy($_FILES['fileToUpload']['tmp_name'], $uploadfile))
            {
                echo "<h3>Файл успешно загружен на сервер</h3>";
            } else {
                echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
                exit;
            }

            // Выводим информацию о загруженном файле:
            /*echo "<h3>Информация о загруженном на сервер файле: </h3>";
            echo "<p><b>Оригинальное имя загруженного файла: ".$_FILES['fileToUpload']['name']."</b></p>";
            echo "<p><b>Mime-тип загруженного файла: ".$_FILES['fileToUpload']['type']."</b></p>";
            echo "<p><b>Размер загруженного файла в байтах: ".$_FILES['fileToUpload']['size']."</b></p>";
            echo "<p><b>Временное имя файла: ".$_FILES['fileToUpload']['tmp_name']."</b></p>";*/
        }

        //$sql = "SELECT id FROM letters WHERE microtime = :microtime";
        $sql = "SELECT * FROM letters WHERE microtime = :microtime";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':microtime',$_POST['microtime']);
        oci_execute($stmt);

        //$result = oci_fetch_assoc($stmt);
        //return $result;
        return oci_fetch_assoc($stmt);
    }

    /**
     * Редактирование существующего письма
     * @return array|false
     */
    public function updateLetter()
    {
        $conn = DB::connToORACLE();

        $sql = "UPDATE letters 
                SET res = :res,
                    dateStart = to_date(:dateStart, 'yyyy-mm-dd'),
                    timeStart = to_date(:timeStart, 'HH24:MI:SS'),
                    dateEnd = to_date(:dateEnd, 'yyyy-mm-dd'),
                    timeEnd = to_date(:timeEnd, 'HH24:MI:SS'),
                    typeOfWork = :typeOfWork,
                    placeOfWork = :placeOfWork,
                    conditionOfWork = :conditionOfWork,
                    supervisor = :supervisor,
                    supervisorPhone = :supervisorPhone,
                    supervisorGroup = :supervisorGroup,
                    responsibleLift = :responsibleLift,
                    responsibleCrane = :responsibleCrane,
                    brigade = :brigade,
                    lift = :lift,
                    crane = :crane,
                    otherTech = :otherTech,
                    provider = :provider
                WHERE
                    id = :id 
                    AND microtime = :microtime 
                    AND status NOT IN (1,2,3,4)";

        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $_GET['id']);
        oci_bind_by_name($stmt, ":microtime", $_POST['microtime']);
        oci_bind_by_name($stmt, ":res", $_POST['res']);
        oci_bind_by_name($stmt, ":dateStart", $_POST['dateStart']);
        oci_bind_by_name($stmt, ":timeStart", $_POST['timeStart']);
        oci_bind_by_name($stmt, ":dateEnd", $_POST['dateEnd']);
        oci_bind_by_name($stmt, ":timeEnd", $_POST['timeEnd']);
        oci_bind_by_name($stmt, ":typeOfWork", $_POST['typeOfWork']);
        oci_bind_by_name($stmt, ":placeOfWork", $_POST['placeOfWork']);
        oci_bind_by_name($stmt, ":conditionOfWork", $_POST['conditionOfWork']);
        oci_bind_by_name($stmt, ":supervisor", $_POST['supervisor']);
        oci_bind_by_name($stmt, ":supervisorPhone", $_POST['supervisorPhone']);
        oci_bind_by_name($stmt, ":supervisorGroup", $_POST['supervisorGroup']);
        oci_bind_by_name($stmt, ":responsibleLift", $_POST['responsibleLift']);
        oci_bind_by_name($stmt, ":responsibleCrane", $_POST['responsibleCrane']);
        oci_bind_by_name($stmt, ":brigade", $_POST['brigade']);
        oci_bind_by_name($stmt, ":lift", $_POST['lift']);
        oci_bind_by_name($stmt, ":crane", $_POST['crane']);
        oci_bind_by_name($stmt, ":otherTech", $_POST['otherTech']);
        oci_bind_by_name($stmt, ':provider',$_SESSION['userId']);   //TODO $_SESSION['providerId']
        oci_execute($stmt);

        $sql = "SELECT id FROM letters WHERE microtime = :microtime";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':microtime',$_POST['microtime']);
        oci_execute($stmt);
        return oci_fetch_assoc($stmt);
    }

    /**
     * Удаление письма
     */
    public function deleteLetter()
    {
        $conn = DB::connToORACLE();
        $sql = "DELETE 
                FROM letters
                WHERE id = :id AND status NOT IN (1,2,3)";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $_POST['letterId']);
        oci_execute($stmt);
    }

    /**
     * Отправка письма на рассмотрение
     */
    public function sendLetter()
    {
        $conn = DB::connToORACLE();
        // определяем номер РЕС, на котором планируются работы
        $sql = "SELECT res 
                FROM letters 
                WHERE id = :id";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $_POST['letterId']);
        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }

        $time = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''))->setTimeZone(new DateTimeZone('Europe/Kiev'))->format("d-m-Y H:i:s.u");

        // при подаче заявки проставляем статус, номер письма для РЕС, дату подачи письма
        $sql = "UPDATE letters 
                SET status = 1,
                    resnum = 1 + (SELECT COUNT(res) FROM letters WHERE res = :res AND status != 0),
                    datesend = :datesend
                WHERE id = :id 
                      AND status NOT IN (1,2,3)";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $_POST['letterId']);
        oci_bind_by_name($stmt, ':res', $result[0]['RES']);
        oci_bind_by_name($stmt, ':datesend', $time);
        oci_execute($stmt);
        // возвращаем ID письма для записи в лог
        return $_POST['letterId'];
    }

    /*----- ДЛЯ ОБЛЭНЕРГО -----*/

    // TODO задвоилось?
    /**
     * Получение всех писем для Облэнерго
     * @return array
     */
    public function getAllLettersEmployeers()
    {
        $conn = DB::connToORACLE();
        if ($_SESSION['res'] == 0) {
            $sql = "SELECT
                    l.id,
                    l.microtime,
                    l.provider as providerid,
                    p.provider as provider,
                    l.res as resid,
                    r.name as res,
                    to_char(l.dateStart, 'dd.mm.yyyy') as dateStart,
                    to_char(l.timeStart, 'HH24:MM') as timeStart,
                    to_char(l.dateEnd, 'dd.mm.yyyy') as dateEnd,
                    to_char(l.timeEnd, 'HH24:MM') as timeEnd,
                    l.typeOfWork,
                    l.placeOfWork,
                    l.conditionOfWork,
                    l.supervisor as supervisorid,
                    s.fullname as supervisor,
                    l.supervisorPhone,
                    l.supervisorGroup,
                    l.responsibleLift,
                    l.responsibleCrane,
                    l.brigade,
                    l.lift,
                    l.crane,
                    l.otherTech,
                    l.status,
                    l.resnum,
                    l.provnum,
                    l.datesend,
                    CASE
                        WHEN l.status = 0 THEN 'нова заявка'
                        WHEN l.status = 1 THEN 'на розгляді'
                        WHEN l.status = 2 THEN 'дозволено без відключення'
                        WHEN l.status = 3 THEN 'дозволено з відключенням'
                        WHEN l.status = 4 THEN 'відмовлено'
                    END AS statustext,
                    l.datepermission,
                    --l.userpermission, 
                    e.id AS userpermission
                FROM letters l 
                LEFT JOIN providers p ON l.provider = p.id
                LEFT JOIN supervisors s ON l.supervisor = s.id
                LEFT JOIN res r ON l.res = r.res
                LEFT JOIN employees e ON l.userpermission = e.id 
                WHERE l.status IN (1,2,3,4)
                ORDER BY l.id DESC";
            $stmt = oci_parse($conn, $sql);
        } else {
            $sql = "SELECT
                    l.id,
                    l.microtime,
                    --l.provider,
                    p.provider,
                    l.res as resid,
                    r.name as res,
                    to_char(l.dateStart, 'dd.mm.yyyy') as dateStart,
                    to_char(l.timeStart, 'HH24:MM') as timeStart,
                    to_char(l.dateEnd, 'dd.mm.yyyy') as dateEnd,
                    to_char(l.timeEnd, 'HH24:MM') as timeEnd,
                    l.typeOfWork,
                    l.placeOfWork,
                    l.conditionOfWork,
                    l.supervisor as supervisorid,
                    s.fullname as supervisor,
                    l.supervisorPhone,
                    l.supervisorGroup,
                    l.responsibleLift,
                    l.responsibleCrane,
                    l.brigade,
                    l.lift,
                    l.crane,
                    l.otherTech,
                    l.status,
                    l.resnum,
                    l.provnum,
                    l.datesend,
                    CASE
                        WHEN l.status = 0 THEN 'нова заявка'
                        WHEN l.status = 1 THEN 'на розгляді'
                        WHEN l.status = 2 THEN 'дозволено без відключення'
                        WHEN l.status = 3 THEN 'дозволено з відключенням'
                        WHEN l.status = 4 THEN 'відмовлено'
                    END AS statustext
                FROM letters l 
                LEFT JOIN providers p ON l.provider = p.id
                LEFT JOIN supervisors s ON l.supervisor = s.id
                LEFT JOIN res r ON l.res = r.res
                WHERE l.status IN (1,2,3,4)
                      AND l.res = :res
                ORDER BY l.id DESC";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':res', $_SESSION['res']);
        }

        oci_execute($stmt);

        // каждая строка из БД это ассоциативный массив
        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }

        if (isset($result)) {
            return $result;
        }

    }

    /**
     * Получение списка всех провайдеров для Облэнерго
     * используем в фильтре и при формировании ПДФ
     * @return array
     */
    public function getAllProvidersList()
    {
        $conn = DB::connToORACLE();
        $sql = "SELECT ID, PROVIDER, DIRECTOR FROM PROVIDERS";
        $stmt = oci_parse($conn, $sql);
        //oci_bind_by_name($stmt, ':provider', $_SESSION['userid']);
        oci_execute($stmt);

        // каждая строка из БД это ассоциативный массив
        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * Разрешить работы без отключения линии
     * 0-создано,1-подано,2-подтверждено без отключения,3-подтверждено с отключением,4-отклонено
     */
    public function allowWithoutDisconnecting()
    {
        $time = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''))->setTimeZone(new DateTimeZone('Europe/Kiev'))->format("d-m-Y H:i:s.u");

        $conn = DB::connToORACLE();
        // TODO того кто выдал
        // при выдаче разрешения проставляем статус, дату выдачи разрешения, того кто выдал
        $sql = "UPDATE letters 
                SET status = 2,
                    datepermission = :datepermission,
                    userpermission = :userpermission
                WHERE id = :id AND status NOT IN (0,3,4)";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $_POST['letterId']);
        oci_bind_by_name($stmt, ':datepermission', $time);
        oci_bind_by_name($stmt, ':userpermission', $_SESSION['userId']);
        oci_execute($stmt);
        // возвращаем ID письма для записи в лог
        return $_POST['letterId'];
    }

    /**
     * Разрешить работы с отключением линии
     * 0-создано,1-подано,2-подтверждено без отключения,3-подтверждено с отключением,4-отклонено
     */
    public function allowWithDisconnecting()
    {
        $time = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''))->setTimeZone(new DateTimeZone('Europe/Kiev'))->format("d-m-Y H:i:s.u");

        $conn = DB::connToORACLE();
        // TODO того кто выдал
        // при выдаче разрешения проставляем статус, дату выдачи разрешения, того кто выдал
        $sql = "UPDATE letters 
                SET status = 3,
                    datepermission = :datepermission,
                    userpermission = :userpermission
                WHERE id = :id AND status NOT IN (0,2,4)";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $_POST['letterId']);
        oci_bind_by_name($stmt, ':datepermission', $time);
        oci_bind_by_name($stmt, ':userpermission', $_SESSION['userId']);
        oci_execute($stmt);
        // возвращаем ID письма для записи в лог
        return $_POST['letterId'];
    }

    /**
     * Отказать в проведении работ
     * 0-создано,1-подано,2-подтверждено без отключения,3-подтверждено с отключением,4-отклонено
     */
    public function refuseToCarryOutWork()
    {
        $time = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''))->setTimeZone(new DateTimeZone('Europe/Kiev'))->format("d-m-Y H:i:s.u");

        $conn = DB::connToORACLE();
        // TODO того кто выдал и причину отказа
        // при выдаче отказа проставляем статус, дату выдачи отказа, того кто выдал
        $sql = "UPDATE letters 
                SET status = 4
                WHERE id = :id AND status NOT IN (0,2,3)";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $_POST['letterId']);
        oci_execute($stmt);
    }



    /**
     * Поиск писем по фильтру для всех
     * @param $provider
     * @param $res
     * @param $dateStart
     * @param $dateEnd
     * @return array|void
     */
    public function searchLetters($provider, $res, $dateStart, $dateEnd)
    {
        $sql = "SELECT
                    l.id,
                    l.microtime,
                    l.provider as providerid,
                    p.provider as provider,
                    l.res as resid,
                    r.name as res,
                    to_char(l.dateStart, 'dd.mm.yyyy') as dateStart,
                    to_char(l.timeStart, 'HH24:MM') as timeStart,
                    to_char(l.dateEnd, 'dd.mm.yyyy') as dateEnd,
                    to_char(l.timeEnd, 'HH24:MM') as timeEnd,
                    l.typeOfWork,
                    l.placeOfWork,
                    l.conditionOfWork,
                    l.supervisor as supervisorid,
                    s.fullname as supervisor,
                    l.supervisorPhone,
                    l.supervisorGroup,
                    l.responsibleLift,
                    l.responsibleCrane,
                    l.brigade,
                    l.lift,
                    l.crane,
                    l.otherTech,
                    l.status,
                    l.resnum,
                    l.provnum,
                    l.datesend,
                    CASE
                        WHEN l.status = 0 THEN 'нова заявка'
                        WHEN l.status = 1 THEN 'на розгляді'
                        WHEN l.status = 2 THEN 'дозволено без відключення'
                        WHEN l.status = 3 THEN 'дозволено з відключенням'
                        WHEN l.status = 4 THEN 'відмовлено'
                    END AS statustext
                FROM letters l 
                LEFT JOIN providers p ON l.provider = p.id
                LEFT JOIN supervisors s ON l.supervisor = s.id
                LEFT JOIN res r ON l.res = r.res
                WHERE l.status IN (0,1,2,3,4)";

        // обрабатываем переданные условия поиска
        $conditions = array();

        /*
        if ($provider != '' && $provider != '0') {
            $conditions[] = "(l.provider = ".$provider.")";
        }
        */

        // Если сотрудник ПРОВАЙДЕРА
        if ($_SESSION['roleId'] == 0) {
            // обязательно добавляем условие
            $conditions[] = "(l.provider = :provider)";
        }

        // Если сотрудник ОБЛЭНЕРГО
        if ($_SESSION['roleId'] == 1) {
            // и если задан поиск по провайдеру/передана переменная
            //if ($provider != '' && $provider != '0') {
            if ($provider != '') {
                // добавляем условие
                //$conditions[] = "(l.provider = ".$provider.")";
                $conditions[] = "(l.provider = :provider)";
            }
        }

        /*if ($res != '') {
            $conditions[] = "(l.res = :res)";
        }*/
        if ($res != '') $conditions[] = "(l.res = :res)";
        //TODO надо биндить условия
        if ($dateStart != '') $conditions[] = "(l.datestart >= to_date('".$dateStart."', 'yyyy-mm-dd'))";
        if ($dateEnd != '') $conditions[] = "(l.dateend <= to_date('".$dateEnd."', 'yyyy-mm-dd'))";

        // собираем условия
        $where = implode(' AND ', $conditions);
        if ($where != '') {
            $where = ' AND '.$where;
        }
        /*echo "<pre>";
        var_dump($where);
        echo "</pre>";*/

        // собираем запрос
        $sql .= $where." ORDER BY l.id DESC";

        /*echo "<pre>";
        var_dump($sql);
        echo "</pre>";*/

        $conn = DB::connToORACLE();
        $stmt = oci_parse($conn, $sql);

        // если сотрудник ПРОВАЙДЕРА
        if ($_SESSION['roleId'] == 0) {
            oci_bind_by_name($stmt, ':provider', $_SESSION['providerId']);
        }
        // если сотрудник РЕС
        // TODO
        // если сотрудник ОБЛЭНЕРГО
        if ($_SESSION['roleId'] == 1 && $_SESSION['res'] == 0) {
            // и если задан поиск по провайдеру/передана переменная
            if ($provider != '') {
                oci_bind_by_name($stmt, ':provider', $provider);
            }
        }

        if ($res != '') {
            oci_bind_by_name($stmt, ':res', $res);
        }

        oci_execute($stmt);

        // каждая строка из БД это ассоциативный массив
        while ($row = oci_fetch_assoc($stmt)) {
            $result[] = $row;
        }

        if (isset($result)) {
            return $result;
        }

    }

}