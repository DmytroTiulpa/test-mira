<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php") ?>
</head>

<body>

<div class="uk-section uk-section-xsmall uk-section-muted uk-height-viewport uk-flex uk-flex-center uk-flex-middle">
    <div class="uk-container uk-container-large uk-height-1-1 uk-flex uk-flex-center uk-flex-middle">
        <div class="uk-card uk-card-default uk-card-small" style="width: 500px;">

            <div class="uk-card-body">

                <form method="post">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend uk-text-center">Регистрация пользователя</legend>

                        <?php
                        if (!empty($pageData['error'])) :
                            for ($i = 0; $i < count($pageData['error']); $i++) { ?>
                            <div class="uk-alert-danger uk-margin-remove-bottom uk-alert" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-icon uk-close" data-uk-close=""></a>
                                <p><?php echo $pageData['error'][$i]; ?></p>
                            </div>
                        <?php
                            }
                        endif;
                        ?>

                        <div class="uk-margin-small-top">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" data-uk-icon="icon: location"></span>
                                    <!--<label class="uk-form-label" for="res">Оберіть найменування філії:</label>-->
                                    <select class="uk-select" name="position" required style="padding-left: 40px;">
                                        <option value="" disabled <?php print (!isset($_POST['position']) ? "selected" : "" ) ?> > - выберите должность - </option>
                                        <option value="boss" <?php print ((isset($_POST['position']) and $_POST['position'] === "boss") ? "selected" : "" ) ?> >директор</option>
                                        <option value="manager" <?php print ((isset($_POST['position']) and $_POST['position'] === "manager") ? "selected" : "" ) ?> >менеджер</option>
                                        <option value="performer" <?php print ((isset($_POST['position']) and $_POST['position'] === "performer") ? "selected" : "" ) ?> >исполнитель</option>
                                    </select>
                            </div>
                        </div>

                        <div class="uk-margin-small-top">
                            <div class="uk-inline uk-width-1-1">
                                <i class="fas fa-envelope"></i>
                                <span class="uk-form-icon " data-uk-icon="icon: mail"></span>
                                    <!--<label class="uk-form-label" for="email">E-mail:</label>
                                    <div class="uk-form-controls">-->
                                        <input id="" class="uk-input" type="text" name="email"
                                               placeholder="E-mail"
                                               value="<?php print (isset($_POST['email']) ? $_POST['email'] : "" ) ?>" required>
                                    <!--</div>-->
                            </div>
                        </div>

                        <div class="uk-margin-small-top">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" data-uk-icon="icon: lock"></span>
                                    <!--<label class="uk-form-label" for="password">Пароль:</label>
                                    <div class="uk-form-controls">-->
                                        <input id="" class="uk-input" type="password" name="password"
                                               placeholder="Пароль"
                                               value="<?php print (isset($_POST['password']) ? $_POST['password'] : "" ) ?>" required>
                                    <!--</div>-->
                            </div>
                        </div>

                        <div class="uk-margin-small-top">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" data-uk-icon="icon: lock"></span>
                                    <!--<label class="uk-form-label" for="password2">Пароль ще раз:</label>
                                    <div class="uk-form-controls">-->
                                        <input id="" class="uk-input" type="password" name="password2"
                                               placeholder="Пароль еще раз"
                                               value="<?php print (isset($_POST['password2']) ? $_POST['password2'] : "" ) ?>" required>
                                    <!--</div>-->
                            </div>
                        </div>

                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                                Регистрация
                            </button>
                        </div>

                        <a href="/">Авторизация</a>

                    </fieldset>
                </form>

            </div>
        </div>

    </div>
</div>

<!-- модальнеое окно успешной регистрации -->
<div id="modal-center" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

    </div>
</div>

<footer>

</footer>

<!--Подключаем jQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<!-- Cabinet styles & scripts-->
<link rel="stylesheet" href="/css/cabinet.css" "/>
<script src="/js/script.js"></script>

</body>
</html>
