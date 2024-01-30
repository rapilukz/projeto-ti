<!DOCTYPE html>
<?php
session_start();
include './includes/reusable_views.inc.php';
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

        <!-- JS -->
        <script src="./scripts/profileData.js" defer></script>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />


        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

        <!-- JS -->
        <script src="scripts/generics.js"></script>
        <script src="scripts/teamData.js"></script>
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
            <div class="d-flex mb-3 justify-content-between">
                <button class="btn btn-primary insert-button"><i class="fa fa-plus"></i>
                    Insert</button>
                <div class="input-group" id="search-container">
                    <input type="text" oninput="searchTable();" id="search" class="form-control" placeholder="Search by Name" aria-label="search">
                    <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </div>
            <table class="table table-bordered text-center" id="team-table">
                <thead>
                    <tr class="table-header">
                        <th class="fw-lighter" scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Foundation Year</th>
                        <th scope="col">Country</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
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
                    <h5 class="modal-title">Edit Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name">

                        <label for="foundation-year" class="form-label">Foundation Year</label>
                        <input type="number" min="1800" max="2099" name="foundation-year" class="form-control" id="foundation-year">

                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" id="country">

                        <div id="errors" class="mt-2"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="updateTeam()" class="btn btn-primary modal-edit-button"><i class="fas fa-save"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>