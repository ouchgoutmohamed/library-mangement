<header class="header" id="header">
<div class="header_toggle"> <i id="header-toggle" class='fa fa-bars' ></i> </div>
    <div class="header_items">
        <?php
            echo '<div class="header_item">Guest</div>';
            echo'<div class="header_img"> <img id="userImg" src="https://images.macrumors.com/t/n4CqVR2eujJL-GkUPhv1oao_PmI=/1600x/article-new/2019/04/guest-user-250x250.jpg"" alt=""> </div>';
       
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
   

    // Generate the navigation links based on the user's role
    $navigation_links = '';
       $navigation_links .= '<a href="./login.php" class="nav_link '.(basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '').'"><i class="fa fa-sign-in nav_icon"></i><span class="nav_name">Login</span></a>';
    


    // Return the generated navigation links
    return $navigation_links;
}
?>
