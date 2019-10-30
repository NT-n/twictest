<!---共通処理--->
<?php
// 接続処理
function connectionDb(){
    $url = parse_url(getenv('HEROKU_POSTGRESQL_NAVY_URL'));
    $host = $url["host"];
    $user = $url["user"];
    $password = $url["pass"];
    $dbname = substr($url["path"], 1);

    $link = pg_connect("host=$host dbname=$dbname user=$user password=$password");
    if (!$link) {
        die('接続失敗です。'.pg_last_error());
        return NULL;
    } else {
        return $link;
    }
}

// メッセージ表示処理
function selectMsg(){
    try{
        // 変数の初期化
        $res = null;

        // 接続
        $link = connectionDb();
        if (is_null($link)) {
            return;
        }

        // SQLクエリ実行
    	$res = pg_query($link, 'SELECT I_MSG FROM t_msg_tr;');
        if (!$res) {
            echo $res;
            die('クエリーが失敗しました。'.pg_last_error());
        }

        // 画面表示
        echo "<div class='parent'>";
        for ($i = 0 ; $i < pg_num_rows($res) ; $i++){
            $rows = pg_fetch_array($res, NULL, PGSQL_ASSOC);
            echo "<div class='kobako'>{$rows['i_msg']}</div>";
        }
        echo "</div>";

    } catch ( Exception $e ) {
        echo "エラー:{$e->getMessage()}";
    }

    // 接続解除
    pg_close($link);
}

// メッセージ登録処理
function insertMsg($Inmsg){
    if (empty($Inmsg)){
    } else {
        try{
            // 変数の初期化
            $res = null;

            // 接続
            $link = connectionDb();
            if (is_null($link)) {
                return;
            }

            // Insert
            $uuid = md5(uniqid(rand(),1));
            $id  = "User";
            $msg = htmlspecialchars($Inmsg);

            $wkSql = "";
            $wkSql = $wkSql."INSERT INTO T_MSG_TR";
            $wkSql = $wkSql."(";
            $wkSql = $wkSql."I_UUID, I_ID, I_MSG, I_ADD_DATE";
            $wkSql = $wkSql.") VALUES (";
            $wkSql = $wkSql."'$uuid', '$id', '$msg', NOW()";
            $wkSql = $wkSql.")";

            // SQLクエリ実行
        	$res = pg_query($link, $wkSql);

        } catch ( Exception $e ) {
            echo "エラー:{$e->getMessage()}";
        }

        // 接続解除
        pg_close($link);
    }
}

?>
