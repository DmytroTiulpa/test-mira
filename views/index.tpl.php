<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <?php include("includes/head.php") ?>
</head>

<body>

<div class="uk-section uk-section-xsmall uk-section-muted uk-height-viewport uk-flex uk-flex-center uk-flex-middle">
    <div class="uk-container uk-container-large uk-height-1-1 uk-flex uk-flex-center uk-flex-middle">
        <div class="uk-card uk-card-default" style="width: 500px;">

            <div class="uk-card-body">

                <form id="form-signin" class ="form-signin" method="post">

                    <?php if (!empty($pageData['error'])) : ?>
                        <div class="uk-alert-danger uk-margin-remove-bottom uk-alert" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-icon uk-close" data-uk-close=""></a>
                            <p><?php echo $pageData['error']; ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1-1">
                            <span class="uk-form-icon" data-uk-icon="icon: user"></span>
                            <label for="email"></label>
                            <input id="email" name="email" type="text" class="uk-input" placeholder="Email">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1-1">
                            <span class="uk-form-icon" data-uk-icon="icon: lock"></span>
                            <label for="password"></label>
                            <input id="password" name="password" type="password" class="uk-input" placeholder="Пароль">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                            <span class="ion-forward"></span>&nbsp; Авторизация
                        </button>
                    </div>

                    <a href="registration">Регистрация пользователя</a>

                </form>
            </div>
        </div>

    </div>
</div>

<?php
/*echo "<div class='uk-card uk-card-default uk-card-small uk-card-body uk-margin-small-bottom'>";

echo '$_SESSION';
echo "<pre><small>";
var_dump($_SESSION);
echo "</small></pre>";

echo '$_COOKIE';
echo "<pre><small>";
var_dump($_COOKIE);
echo "</small></pre>";

echo '$pageData';
echo "<pre><small>";
var_dump($pageData);
echo "</small></pre>";

$arr = get_defined_vars();
var_dump($arr);

echo "</div>";*/
?>

<footer>
</footer>

<!--Подключаем jQuery-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>-->

<!-- Cabinet styles & scripts-->
<link rel="stylesheet" href="/css/style.css" "/>
<!--<script src="/js/script.js"></script>-->

</body>
</html>
