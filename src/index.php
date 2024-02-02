<!DOCTYPE html>
<?php
include './includes/reusable_views.inc.php';
session_start();
?>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- CSS  -->
		<link rel="stylesheet" href="css/styles.css" />

		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

		<!-- JS -->
		<script src="scripts/index.js"></script>

		<!-- Bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

		<!-- JQuery -->
		<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	</head>
	<title>Projeto TI</title>
</head>

<body>
	<header>
		<h1><a class="logo-text" href="#">Projeto Final</a></h1>
		<nav class="main-navbar">
			<?php
			render_main_pages();
			output_user();
			?>
	</header>
	</nav>


	<div id="cards-container" class="d-flex w-100 align-items-center justify-content-center">
		<div class="card" style="width: 18rem;">
			<img src="./images/ronaldo.jpg" class="card-img-top" alt="ronaldo">
			<div class="card-body">
				<h5 class="card-title">Players</h5>
				<p class="card-text">Explore all the avaible players, find their teams and where they come from!</p>
				<a href="./players.php" class="card-btn btn btn-primary">See Players</a>
			</div>
		</div>

		<div class="card" style="width: 18rem;">
			<img src="./images/Equipas.jpg" class="card-img-top" alt="equipas">
			<div class="card-body">
				<h5 class="card-title">Teams</h5>
				<p class="card-text">Discover football teams' histories, their foundation year and the country they were born in!</p>
				<a href="./teams.php" class="card-btn btn btn-primary">See Teams</a>
			</div>
		</div>

		<div class="card" style="width: 18rem;">
			<img src="./images/jose-mourinho.jpg" class="card-img-top" alt="jose mourinho">
			<div class="card-body">
				<h5 class="card-title">Trainers</h5>
				<p class="card-text">Explore our team's coaches and their history, capabilities, license and more!</p>
				<a href="./trainers.php" class="card-btn btn btn-primary">See Trainers</a>
			</div>
		</div>
	</div>

</body>

</html>