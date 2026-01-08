<title>Sanchalana 2k20</title>
<style>
.bgImage {
    background-image: url(images/bg.png);
    background-size: cover;
    background-position: center center;
    height: 650px;
    margin-bottom: 25px;
    background-repeat: no-repeat;
    filter: brightness(95%);
}

</style>
<header class="bgImage" > 
    <nav class="navbar" >
        <div class="container">
        <div class="navbar-header"><!--website name/title-->
               
                <button type="button" class="navbar-toggle" onclick="openNav()">
                    <i class="fa-solid fa-bars" style="color: #63E6BE; font-size: 24px;"></i>
                </button>
                <a href="index.php" class = "navbar-brand">
                   <h2><img src="images/logo.png" alt="MSU Events" style="height:100px;"></h2>
                </a>
        </div>
        
        <!-- Navigation menu for large devices -->
        <div class="navbar-menu-large">
            <a href="index.php"><strong>Home</strong></a>
            <a href="contact.php"><strong>Contact Us</strong></a>
            <a href="aboutus.php"><strong>About us</strong></a>
            <a class="btnlogin" href="login_form.php"><strong>Login</strong> <span class="glyphicon glyphicon-log-in"></span></a>
        </div>
        
        <!-- Hidden sidenav for mobile -->
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="index.php"><strong>Home</strong></a>
            <a href="contact.php"><strong>Contact Us</strong></a>
            <a href="aboutus.php"><strong>About us</strong></a>
            <a class="btnlogin" href="login_form.php"><strong>Login</strong> <span class="glyphicon glyphicon-log-in"></span></a>
        </div>
        
        <!-- Overlay for sidenav -->
        <div id="overlay" class="overlay" onclick="closeNav()"></div>
        </div><!--container div-->
    </nav>
    <div class = "col-xs-12 col-sm-12 col-md-12">
        <div class = "container">
            <div class = "jumbotron"><!--jumbotron-->
                <h1><strong>Explore<br></strong> Your Favorite Event</h1><!--jumbotron heading-->
                <p style="font-style: bold; font-size: 18px;">"Limitation-It's just your imagination,so just stop thinking about limitation and think about your goal and run towards it to acheive the peak of your goal:)"</p>
                <br>
                <br><div class="browse d-md-flex col-xs-12 col-sm-12 col-md-14" >
                <div class="row">
                   
            </div>
        </div>
    </div>
</header>

<!-- JavaScript for slide-in menu -->
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("overlay").style.display = "block";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("overlay").style.display = "none";
}
</script>