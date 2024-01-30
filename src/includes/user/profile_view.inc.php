<?php

function output_profile_user()
{
    if (isset($_SESSION["user_id"])) {
        echo '<ul class="links d-flex">
    <li><a href="../user-list.php" class="link">User List</a></li>
    <div class="dropdown">
        <button class="btn dropdown-toggle dropdown-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li class="username-container"><a href="#" class="dropdown-item username">' . $_SESSION["user_username"] . '</a></li>
        <li><a class="dropdown-item second-item" href="#"><i class="fa-solid fa-user"></i>Profile</a></li>
            <form action="../includes/login/logout.inc.php" method="POST">
                <li><a class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> <button type="submit" class="logout-btn dropdown-item">Logout</button></a></li>
            </form>
        </ul>
    </div>
    ';
    } else {
        echo '<div class="buttons-container d-flex">
        <a href="auth/login.php"><button type="button" class="login-btn">Login</button></a>
        <a href="auth/register.php"><button type="button" class="signup-btn">Sign Up</button></a>
    </div>';
    }
}

function render_user_info()
{
    if (isset($_SESSION["user_id"])) {
        echo '<div class="container">
        <div class="row">
            <div class="card mb-3">
                <div class="card-body" data-user-id="' . $_SESSION["user_id"] . '">
                    <div class="d-flex flex-column align-items-center text-center mb-4">
                        <img src="../images/user.png" class="rounded-circle" width="180">
                        <div class="mt-3">
                            <h4 id="profile-main-username">' .  $_SESSION["user_username"] . '</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Username</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="profile-username">
                        ' .  $_SESSION["user_username"] . '
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="profile-email">
                            ' .  $_SESSION["user_email"] . '
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Birthdate</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="profile-birthdate">
                        ' .  $_SESSION["user_birthdate"] . '
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="edit-btn" onclick="showProfileModal(event)"><i class="fa-solid fa-pencil me-2"></i>Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    }
}
