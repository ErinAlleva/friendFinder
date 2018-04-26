
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Friend Finder</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800|Playfair+Display:,300, 400, 700" rel="stylesheet">

	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/mediaelementplayer.min.css">

	<link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">


	<!-- Theme Style -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

	<div class="site-wrap">

	</div>

	<aside style="width:56%;height:98%;background-image: url(images/stepBrothers.jpg);float:center;padding:30px" ></aside>
	<main>
		<h1 class="mb-5">Time to find your new BEST FRIEND</h1>

		<div id = "main" class="container">

			<form action="" method="post" name="form">
				<button type="submit" id="ascend" name="ascend" />Sort by Ascending</button>
				<button type="submit" id="descend" name="descend" />Sort by Descending</button>
				<a href="matches_output.xml" download="matches_output">Download Match Data</a>
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
						header("Location: form2.php");
						session_destroy();
					}
					?>
				</table>

			</div>


		</div>
		<form action="" method="post" name="deleteform">
			<button type="submit" id="delete" name="delete" style="float: center;"/>Delete user</button>
		</form>

	</main>
</div>



<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/main.js"></script>

</body>

</html>
