<?php


function output_user()
{
    if (isset($_SESSION["user_id"])) {
        echo '<ul class="links d-flex">
            <li><a href="./user-list.php" class="link">User List</a></li>
            <div class="dropdown">
                <button class="btn dropdown-toggle dropdown-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="username-container"><a href="./auth/profile.php" class="dropdown-item username">' . $_SESSION["user_username"] . '</a></li>
                    <li><a class="dropdown-item second-item" href="./auth/profile.php"><i class="fa-solid fa-user"></i>Profile</a></li>
                    <form action="./includes/login/logout.inc.php" method="POST">
                        <li><a class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> <button type="submit" class="logout-btn dropdown-item">Logout</button></a></li>
                    </form>
                </ul>
            </div>
           ';
    }
}
