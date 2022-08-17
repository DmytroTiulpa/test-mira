<?php
//var_dump($pageData);
//var_dump($_SESSION);
//$arr = get_defined_vars();
//var_dump($arr);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php") ?>
</head>

<body>

<div class="uk-section uk-section-xsmall uk-section-muted uk-height-viewport uk-flex uk-flex-center uk-flex-middle">
    <div class="uk-container uk-container-large uk-height-1-1 uk-flex uk-flex-center uk-flex-middle">
        <div class="uk-card uk-card-default" style="width: 500px;">
            <div class="uk-card-body">
                <div>
                    <?php echo $pageData['message']; ?>
                </div>
                <a href="/">Авторизация</a>
            </div>
        </div>
    </div>
</div>


<footer>

</footer>

<!--Подключаем jQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<!-- Cabinet styles & scripts-->
<link rel="stylesheet" href="/css/style.css" "/>
<!--<script src="/js/script.js"></script>-->

</body>
</html>
