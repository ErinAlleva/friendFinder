<?php

class DbUtil{
   public static $user = "CS4750eaa4deb";
   public static $pass = "spring2018";
   public static $host = "stardock.cs.virginia.edu";
   public static $schema = "CS4750eaa4de";

   public static function loginConnection() {
      $db = new mysqli(DbUtil::$host, DbUtil::$user,
      DbUtil::$pass, DbUtil::$schema);
      if($db->connect_errno) {
        echo "fail";
        $db->close();
        exit();
      }
      return $db;
  }

}

$link = DbUtil::loginConnection();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="main.css">
  <title>Who Are Your Friends?</title>
</head>

<body>

  <header>

    <h1>Who Are Your Friends?</h1>
    <h2> Lets find out...</h2> 
    <h2 style="text-align:center;">

    <img src="https://fthmb.tqn.com/HABuBz4TMR_E1etOztOkcmGGL8E=/768x0/filters:no_upscale()/meme1-56a3320f5f9b58b7d0d0e975.jpeg" width="30%" height="30%" ></h2>

  </header>

<div id = "main" class="container">

  <form action="" method="post" name="form">
    <button type="submit" id="ascend" name="ascend" />Sort by Ascending</button>
    <button type="submit" id="descend" name="descend" />Sort by Descending</button>
    <button type="submit" id="delete" name="delete" style="float: right;"/>Delete user</button>
  </form>

  <div id = "main" class="sectionDiv" style="display:flex;justify-content:center;align-items:center;">

    <table id="myTable">
      <tr class="header">
        <th style="width:40%; text-align: left;">Name</th>
        <th style="width:30%; text-align: left;">Computing ID</th>
        <th style="width:25%; text-align: left;">Age</th>
        <th style="width:25%; text-align: left;">Match</th>
      </tr>
      <?php 
        ob_start();
        session_start();
        echo $_SESSION["output"];
        if (isset($_POST["ascend"])){
          ob_end_clean();
          echo $_SESSION["output_asc"];
        }

        if (isset($_POST["descend"])){
          ob_end_clean();
          echo $_SESSION["output"];
        }

        if (isset($_POST["delete"])){
          ob_end_clean();
          $delete = "DELETE FROM Person WHERE compID = '".$_SESSION["compID"]."'";
          $delete_query = mysqli_query($link, $delete);
          header("Location: form.php");
          session_destroy();
        }
      ?>
    </table>

  </div>

</div>




  

</body>



</html>













