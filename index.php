<html>
<head>
<title>簡易掲示板</title>
</head>
<body>
  <form method="post">
    <textarea name="textarea" rows="10" cols="50" placeholder="Write Something Here"></textarea>
    <button type="submit" name="action" value="send">送信</button>
    <button type="submit" name="reversed" value="send">逆順にソート</button>
  </form>
  <hr>
  <?php
    if(isset($_POST["action"])) {
      $contents = $_POST["textarea"];
      $conn = pg_pconnect("host=localhost dbname=keijiban_test");
      if(!$conn) {
        echo "An error occurred.\n";
        exit;
      }
      $result = pg_query($conn, "select max(id) from keijiban;");
      $row = pg_fetch_row($result);
      $row[0] += 1;
      pg_query($conn, "insert into keijiban(id,contents) values('{$row[0]}','{$contents}');");
      $result = pg_query($conn, "select * from keijiban;");
      while($row = pg_fetch_row($result)) {
        print "{$row[1]}<br><hr>";
      }
      pg_close($conn);
    } else if(isset($_POST["reversed"])) {
      $conn = pg_pconnect("host=localhost dbname=keijiban_test");
      if(!$conn) {
        echo "An error occurred.\n";
        exit;
      }
      $result = pg_query($conn, "select * from keijiban order by id desc;");
      while($row = pg_fetch_row($result)) {
        print "{$row[1]}<br><hr>";
      }
      pg_close($conn);
    } else {
      $conn = pg_pconnect("host=localhost dbname=keijiban_test");
      if(!$conn) {
        echo "An error occurred.\n";
        exit;
      }
      $result = pg_query($conn, "select * from keijiban;");
      while($row = pg_fetch_row($result)) {
        print "{$row[1]}<br><hr>";
      }
      pg_close($conn);
    }
   ?>
</body>
</html>
