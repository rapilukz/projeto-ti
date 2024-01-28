<!DOCTYPE html>
<html lang="en">

<?php
require_once '../includes/config-session.inc.php';
require_once '../includes/signup/signup_view.inc.php';
?>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- CSS  -->
	<link rel="stylesheet" href="../css/styles.css" />

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" />

	<!-- JS -->
	<script src="../scripts/index.js"></script>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
	<header>
		<h1 class="logo-text">Projeto Final</h1>
	</header>

	<div class="main-container">
		<div class="container-fluid">
			<form action="../includes/signup/signup.inc.php" method="POST" class="mx-auto">
				<h4 class="text-center">Create an account</h4>

				<div class="mb-3 mt-3">
					<label class="form-label">Username</label>
					<input type="text" class="form-control" name="username" id="username" placeholder="Username">
				</div>

				<div class="mb-3">
					<label class="form-label">Email</label>
					<input type="text" class="form-control" name="email" id="email" placeholder="Email">
				</div>

				<div class="mb-3" id="datepicker">
					<label class="form-label">Birthdate</label>
					<input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="Birthdate">
				</div>

				<div class="mb-3">
					<label class="form-label">Password</label>
					<input type="text" class="form-control" name="password" id="password" placeholder="Password">
				</div>


				<div class="mb-3">
					<label class="form-label">Confirm Password</label>
					<input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password">
					<div class="mt-3 d-flex">
						<span class="sign-in ms-auto">Already have an account?<a href="login.php" class="ms-1">Sign Up</a></span>
					</div>
				</div>

				<?php
				check_signup_erros();
				?>

				<button type="submit" class="btn form-btn mt-3">Sign In</button>

			</form>
		</div>
	</div>
</body>

</html>