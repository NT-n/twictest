<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ひとこと言える</title>
        <link rel="icon" href="favicon.ico">
        <meta name="description" content="ひとこと言える">
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="back">
            <div class="bou">
            </div>
        <!-- カラム左 -->
            <div class="kabe">
                <div class="hako">
                    <form action="index.php" method="post">
                            <input id="text_msg" type="text" name="message">
                        <input id="submit_button" type="submit" value="送">
                    </form>
                    <?php
                        require_once 'common.php';
                        if (!empty($_POST['message'])) {
                            insertMsg(htmlspecialchars($_POST['message']));
                        }
                        selectMsg();
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
