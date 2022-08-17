<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php") ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var count = 0;
        var allData = [];

        function getData(user, id) {
            count++;
            //console.log(user);
            let button = "Кнопка " + id;
            console.log(count);
            if (count > 10) {
                alert("10 записей");
            } else {

                $.ajax({
                    url: "/home/getContent",
                    type: "GET",
                    dataType: 'json',
                    data: {position: user, page: count},
                    success: function (result) {
                        console.log("OK!");
                        let element = "<div><div class='uk-card uk-card-default uk-card-small uk-margin-small-bottom'><div class='uk-card-body'><h3 class='uk-card-title'>" + result['title'] + "</h3><p>" + result['body'] + "</p></div></div></div>";
                        $("#elements").append(element);

                        allData[count-1] = [ result['title'], result['body'], user, button ];
                        console.log(allData);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log("ERROR");
                        console.log( errorThrown );
                    }
                })

            }

        }

        function saveData() {
            if (allData.length !== 0) {
                let jsonData = JSON.stringify(allData);
                //console.log(jsonData);
                $.ajax({
                    url: "/home/saveContent",
                    type: "POST",
                    data: {data: allData},
                    success: function( data, textStatus, jQxhr ){
                        console.log("SAVE - OK");
                        alert("Все записи сохранены в базу, больше ничего не делаем.");
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
            }
        }
    </script>

</head>
<body>
<header>
    <!-- ГЛАВНОЕ МЕНЮ -->
    <?php include("includes/navbar.php") ?>
</header>

<div class="content-background">

    <div class="uk-section uk-section-xsmall uk-section-muted uk-height-viewport">
        <div class="uk-container uk-container-expand">

            <div class="uk-grid-small" data-uk-grid>

                <div class="uk-width-1-1">
                    <h2>Спасибо что вошли, <?php echo $_SESSION['email']; ?></h2>
                </div>

                <div class="uk-width-1-3">
                    <h3>Boss@mail.com</h3>
                    <button id="boss" class="uk-button uk-button-danger uk-width-1-1 uk-margin-bottom"
                            <?php if ($_SESSION['position'] === "manager" || $_SESSION['position'] === "performer" ) { echo "disabled"; } ?>
                            onclick="getData('<?= $_SESSION['position'] ?>', this.id)">Кнопка boss</button>
                </div>

                <div class="uk-width-1-3">
                    <h3>Manager@mail.com</h3>
                    <button id="manager" class="uk-button uk-button-danger uk-width-1-1 uk-margin-bottom"
                            <?php if ($_SESSION['position'] === "performer") { echo "disabled"; } ?>
                            onclick="getData('<?= $_SESSION['position'] ?>', this.id)">Кнопка manager</button>
                </div>

                <div class="uk-width-1-3">
                    <h3>Performer@mail.com</h3>
                    <button id="performer" class="uk-button uk-button-danger uk-width-1-1 uk-margin-bottom"
                            onclick="getData('<?= $_SESSION['position'] ?>', this.id)">Кнопка performer</button>
                </div>
            </div>

            <div id="elements" class="uk-grid-small uk-child-width-1-3 uk-grid-match" data-uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-small uk-margin-small-bottom">
                        <div class="uk-card-body">
                            <h3 class="uk-card-title">Card title</h3>
                            <p>Lorem ipsum <a href="#">dolor</a> sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-small uk-margin-small-bottom">
                        <div class="uk-card-body">
                            <h3 class="uk-card-title">Card title</h3>
                            <p>Lorem ipsum <a href="#">dolor</a> sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-small uk-margin-small-bottom">
                        <div class="uk-card-body">
                            <h3 class="uk-card-title">Card title</h3>
                            <p>Lorem ipsum <a href="#">dolor</a> sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-width-1-1">
                <button class="uk-button uk-button-primary uk-width-1-1" onclick="saveData()">Сохранить все записи</button>
            </div>

        </div>
    </div>
</div>

</body>
</html>