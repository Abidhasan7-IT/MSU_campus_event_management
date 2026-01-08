<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>MSU Admin Panel</title>
    <style>
.bgImage {
    background-image: url(images/bg.png);
    background-size: cover;
    background-position: center center;
    height: 650px;
    margin-bottom: 25px;
    background-repeat: no-repeat;
    filter: brightness(96%);
}
.btnlogout{
    background: #111;
    color: #fff;
    padding: 10px 20px;
    border-radius: 7px;
}
</style>
</head>

        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->


<header class="bgImage" > 
    <nav class="navbar" >
        <div class="container">
            <div class="navbar-header"><!--website name/title-->
              
                <button type="button" class="navbar-toggle" onclick="openNav()">
                    <i class="fa fa-bars"></i>
                </button>
                <a href="adminPage.php" class = "navbar-brand">
                    <h2><img src="images/logo.png" alt="MSU Events" style="height:100px;"></h2>
                </a>
            </div>
            
            <!-- Navigation menu for large devices -->
            <div class="navbar-menu-large">
                <a href="adminPage.php"><strong>Home</strong></a>
                <a href="Stu_details.php"><strong>Student Details</strong></a>
                <a href="Stu_cordinator.php"><strong>Student Co-ordinator</strong></a>
                <a href="Staff_cordinator.php"><strong>Staff-Co-ordinator</strong></a>
                <a class="btnlogout" href="logout.php"><strong>Logout</strong> <span class="glyphicon glyphicon-log-out"></span></a>
            </div>
            
            <!-- Hidden sidenav for mobile -->
            <div id="adminSidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="adminPage.php"><strong>Home</strong></a>
                <a href="Stu_details.php"><strong>Student Details</strong></a>
                <a href="Stu_cordinator.php"><strong>Student Co-ordinator</strong></a>
                <a href="Staff_cordinator.php"><strong>Staff-Co-ordinator</strong></a>
                <a class="btnlogout" href="logout.php"><strong>Logout</strong> <span class="glyphicon glyphicon-log-out"></span></a>
            </div>
            
            <!-- Overlay for sidenav -->
            <div id="overlay" class="overlay" onclick="closeNav()"></div>
        </div><!--container div-->
    </nav>
    <div class = "col-xs-12 col-sm-12 col-md-12">
        <div class = "container">
            <div class = "jumbotron"><!--jumbotron-->
                <h1><strong>Explore<br></strong> Your Favorite Event</h1><!--jumbotron heading-->
                <div class="browse d-md-flex col-xs-12 col-sm-12 col-md-14" >
                <div class="row">
                   
            </div>
        </div>
    </div>
</header>

<!-- JavaScript for slide-in menu -->
<script>
function openNav() {
    document.getElementById("adminSidenav").style.width = "250px";
    document.getElementById("overlay").style.display = "block";
}

function closeNav() {
    document.getElementById("adminSidenav").style.width = "0";
    document.getElementById("overlay").style.display = "none";
}
</script>