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

    <img src="meme.jpg" width="40%" height="40%" ></h2>

  </header>




  <footer>
  </footer>

</body>



</html>











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
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


$sql= "SELECT COUNT(*) compID AS num_people FROM Person";
$num_people = mysqli_query($link,$sql);


 // amout of tr 
echo $num_people;
$rows=$num_people;
$cols = 4;// amjount of td 

function drawTable($rows, $cols)
{
echo "<table border='1'>";
echo "<td align='center'>".$rows*$cols."</td>"; 

for($tr=1;$tr<=$rows;$tr++){ 

    echo "<tr>"; 
        for($td=1;$td<=$cols;$td++){ 
               
        } 
    echo "</tr>"; 
} 

echo "</table>";
}

drawTable($rows,$cols);

$link->close();

?>