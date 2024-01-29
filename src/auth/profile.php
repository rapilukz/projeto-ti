<!DOCTYPE html>
<html lang="en">

<?php
require_once '../includes/profile/profile_view.inc.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
}

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS  -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/profile.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- JS -->
    <script src="../scripts/index.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1 class="logo-text">Projeto Final</h1>
        <nav class="main-navbar">
            <?php
            output_profile_user();
            ?>

        </nav>
    </header>

    <div class="main-container">
        <?php
        render_user_info()
        ?>
    </div>

</body>

</html>