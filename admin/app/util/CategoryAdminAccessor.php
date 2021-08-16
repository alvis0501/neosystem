<?php
/**
 * fugi_categoryテーブルのDBアクセス
 *
 * @author
 */
class CategoryAdminAccessor extends Accessor {

  function getList() {
    $con = DB :: connect($this->dsn);

    if (DB :: isError($con)) {
      return "DB接続エラー:" . DB :: errorMessage($con);
    }

    $sql = "SELECT * FROM fugi_category ORDER BY display_order ";
    $args = null;

    $cat = $con->getAll($sql,$args,DB_FETCHMODE_ASSOC);
    if (DB :: isError($line)) {
      $con->disconnect();
      return "カテゴリ一覧取得時エラー:" . DB :: errorMessage($line);
    }

    $con->disconnect();

    return $cat;
  }

  function getCategory($id) {
    $con = DB :: connect($this->dsn);

    if (DB :: isError($con)) {
      return "DB接続エラー:" . DB :: errorMessage($con);
    }

    $sql = "SELECT * FROM fugi_category WHERE fugi_category_id=?";
    $args = array($id);

    $data = $con->getRow($sql, $args, DB_FETCHMODE_ASSOC);
    if (DB :: isError($data)) {
      $con->disconnect();
      return "指定カテゴリのデータを取得時エラー:" . DB :: errorMessage($data);
    }

    $con->disconnect();
    return $data;
  }

  function insertCategory($data) {
    $con = DB :: connect($this->dsn);

    if (DB :: isError($con)) {
      return "DB接続エラー:" . DB :: errorMessage($con);
    }

    $sql = "INSERT INTO fugi_category(category_name,display_order,register,uptime) VALUES (?,?,?,?)";
    $args = array(
      $data["category_name"],
      $data["display_order"],
      $data["register"],
      $data["uptime"]
    );

    $result = $con->query($sql, $args);
    if (DB :: isError($result)) {
      $con->disconnect();
      if ($GLOBALS['debug']) echo $result;
      if ($GLOBALS['debug']) print_r( $result);
      return "カテゴリ挿入時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
    }

    $con->disconnect();

    return null;
  }

  function updateCategory($id,$data) {
    $con = DB :: connect($this->dsn);

    if (DB :: isError($con)) {
      return "DB接続エラー:" . DB :: errorMessage($con);
    }

    $sql = "UPDATE fugi_category SET category_name=?, display_order=?, uptime=? WHERE fugi_category_id=?";
    $args = array(
      $data["category_name"],
      $data["display_order"],
      $data["uptime"],
      $id
    );

    $result = $con->query($sql, $args);
    if (DB :: isError($result)) {
      $con->disconnect();
      if ($GLOBALS['debug']) echo $result;
      if ($GLOBALS['debug']) print_r( $result);
      return "カテゴリ更新時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
    }

    $con->disconnect();

    return null;
  }

  function deleteCategory($id) {
    $con = DB :: connect($this->dsn);

    if (DB :: isError($con)) {
      return "DB接続エラー:" . DB :: errorMessage($con);
    }

    $sql = "
      DELETE FROM fugi_category WHERE fugi_category_id = ?
    ";
    $args = array(
      $id,
    );

    $result = $con->query($sql, $args);
    if (DB :: isError($result)) {
      $con->disconnect();
      if ($GLOBALS['debug']) echo $result;
      if ($GLOBALS['debug']) print_r( $result);
      return "カテゴリ削除時エラー:" . DB :: errorMessage($result) . ' ### '.$result->userinfo;
    }

    $con->disconnect();

    return null;
  }
}
?>
