<!-- Proudly coded by Billy (https://bybilly.uk) -->
<!-- Version: 1.9.2 -->
<?php
include_once "database/db-connect.php";
include_once "utils/functions.php";

sec_session_start();
if (login_check($mysqli)) {
    header("Location: ../");
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Info meta tags, important for social media + SEO -->
    <title>Login | AuroraMC Leadership Panel | The AuroraMC Network</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon"
          type="image/png"
          href="img/logo.png">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
</head>
<body>
<div class="container">
    <div class="logo">
        <!-- In the img folder, upload your logo -->
        <!-- Make sure you name it 'logo.png' or update the code below -->
        <img src="img/logo.png" alt="AuroraMC logo">
    </div>

    <div class="items">
        <!-- Card -->
        <div class="card mx-xl-5">
            <!-- Card body -->
            <div class="card-body">
                <form action="utils/process-login.php" method="post" name="login_form" id="login_form">

                    <div class="md-form input-group input-group-lg">
                        <fieldset>
                            <input type='text' name='username' id='username' placeholder="Username" class="form-control" /><br>
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control"/><br>
                            <input type="text" name="code" id="code" placeholder="Verification Code" class="form-control"/><br>
                        </fieldset>
                    </div>
                    <button type="button" class="btn btn-default" form="login_form" onclick="formhash(this.form, this.form.username, this.form.password, this.form.code);" id="submit">Login</button></div></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/firefly.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>
