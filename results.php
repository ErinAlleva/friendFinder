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

  <div id = "main" class="sectionDiv" style="display:flex;justify-content:center;align-items:center;">

    <table id="myTable">
      <tr class="header">
        <th style="width:40%; text-align: left;">Name</th>
        <th style="width:30%; text-align: left;">Computing ID</th>
        <th style="width:25%; text-align: left;">Age</th>
        <th style="width:25%; text-align: left;">Match</th>
      </tr>
      <?php 
        session_start();
        echo $_SESSION["output"];
      ?>
    </table>
  </div>


</div>




  

</body>



</html>













