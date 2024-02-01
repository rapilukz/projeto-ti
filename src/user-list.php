<!DOCTYPE html>
<?php
session_start();
include './includes/reusable_views.inc.php';

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
        <link rel="stylesheet" href="css/userTable.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

        <!-- JS -->
        <script src="scripts/generics.js"></script>
        <script src="scripts/userData.js"></script>

    </head>
    <title>Projeto TI</title>
</head>

<body>
    <header>
        <h1><a class="logo-text" href="./index.php">Projeto Final</a></h1>
        <nav class="main-navbar">
            <?php
            render_main_pages();
            output_user();
            ?>

        </nav>
    </header>

    <div class="main-container">
        <div class="container">
            <table class="table text-center" id="user-table">
                <thead>
                    <tr class="table-header">
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Birthdate</th>
                        <th>Role</th>
                        <th class="col-2">Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div id="modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username">

                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email">

                        <label for="birthdateInput" class="form-label">Birthdate</label>
                        <input type="date" name="birthdate" class="form-control" id="birthdate">

                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <!-- Options will be dynamically populated here -->
                        </select>

                        <div id="errors" class="mt-2"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="updateUser()" class="btn btn-primary modal-edit-button"><i class="fas fa-save"></i>Save</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>