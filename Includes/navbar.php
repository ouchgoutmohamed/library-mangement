<header class="header" id="header">
<div class="header_toggle"> <i id="header-toggle" class='fa fa-bars' ></i> </div>
    <div class="header_items">
        <?php
        if(isset($_SESSION["M_ID"])){
            echo'
            <button class="btn" style=" padding: 5px !important; background: #f7f6fb; border-radius:60px;" onclick="window.location.replace(\'my-profile.php\');">
                    <div class="d-flex flex-row">
                    <div class="header_item p-2" style="margin-left: 0pc !important; ">'.$_SESSION["nav_Name"].'</div>
                    <div class="header_img "> <img id="userImg" src="'.$_SESSION["nav_Img"].'" alt=""> </div>
                    </div>
            </button>
            ';
           
        }
        else{
            echo'
            <div class="header_item">'.$_SESSION["nav_Name"].'</div>
            <div class="header_img "> <img id="userImg" src="'.$_SESSION["nav_Img"].'" alt=""> </div>           
       ';
       
        }
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        ?>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> <a href="#" class="nav_logo" style="padding-left: 9px">
                <img src="Images/logo.png" style="width:48px; height: 48px">
                <span class="nav_logo-name">Biblio-Gest</span> </a>
            <div class="nav_list" id="nav_list">
                <?php echo generate_navigation_links(); ?>
            </div>
        </div>

    </nav>
</div>
<?php
function generate_navigation_links() {
    // Start the session
    session_start();

    // Check if the user is logged in as a member or an admin
    $is_member = isset($_SESSION["M_ID"]);
    $is_admin = isset($_SESSION["A_ID"]);

    // Generate the navigation links based on the user's role
    $navigation_links = '';
    $navigation_links .= '<a href="./index.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '').'"><i class="fa fa-home nav_icon"></i><span class="nav_name">Dashboard</span></a>';
    if(!isset($_SESSION["M_ID"]) && !isset($_SESSION["A_ID"])){
        $navigation_links .= '<a href="./book.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'book.php' ? 'active' : '').'"><i class="fa fa-book nav_icon"></i><span class="nav_name">Books</span></a>';
        $navigation_links .= '<a href="./member.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'member.php' ? 'active' : '').'" style="column-gap:20px"><i class="fa fa-user nav_icon"></i><span class="nav_name">Users</span></a>';
        $navigation_links .= '<a href="./reservations.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'reservations.php' ? 'active' : '').'" style="column-gap:20px"><i class="fa fa-calendar nav_icon" style="margin-left: 3px"></i><span class="nav_name">Reservations</span></a>';
        $navigation_links .= '<a href="./includes/logout.php" class="nav_link" id="logout"><i class="fa fa-sign-out nav_icon"></i><span class="nav_name">Logout</span></a>';
    
    }

    if ($is_member) {
        $navigation_links .= '<a href="./my-profile.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'my-profile.php' ? 'active' : '').'" style="column-gap:20px"><i class="fa fa-user nav_icon"></i><span class="nav_name">My Profile</span></a>';
        $navigation_links .= '<a href="./my-reservations.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'my-reservations.php' ? 'active' : '').'" style="column-gap:13px"><i class="fa fa-calendar nav_icon" style="margin-left: 3px"></i><span class="nav_name">My Reservations</span></a>';
    }
   

    if(isset($_SESSION["M_ID"]) || isset($_SESSION["A_ID"])){
        // Add the logout link
        $navigation_links .= '<a href="./includes/logout.php" class="nav_link" id="logout"><i class="fa fa-sign-out nav_icon"></i><span class="nav_name">Logout</span></a>';
    }

    // Return the generated navigation links
    return $navigation_links;
}
?>
