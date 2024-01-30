<!DOCTYPE html>
<?php
session_start();
include './includes/user/user_list_view.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
}
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
        <link rel="stylesheet" href="css/table.css" />

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
        <h1><a class="logo-text" href="./index.php">Projeto Final</a></h1>
        <nav class="main-navbar">
            <?php
            output_user();
            ?>

        </nav>
    </header>

    <div class="main-container">
        <div class="container">
            <div class="input-group mb-5" id="search-container">
                <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i>
                </span>
                <input type="text" oninput="searchTable();" id="search" class="form-control" placeholder="Search by username" aria-label="search" aria-describedby="basic-addon1">
            </div>
            <table class="table" id="user-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Birthdate</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        fillUsersTable();
    </script>
</body>

</html>