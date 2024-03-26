<?php

if (!empty($_POST)){
    $errors = [];
    if (empty($errors)){
        $data = [];
        if(empty($_POST["username"])){
            $errors['username'] = "A username is required";
        }else if(!preg_match("/^[a-zA-Z]$/",$_POST['username'])){
            $errors['username'] = "username can only have letters and no space";
        }

            $query = "select id from users where email = :email limit 1";
            $email = run_query($query,['email'=> $_POST["email"]]);


        if(empty($_POST["email"])) {
            $errors['email'] = "A email is required";
        }else if($email){
            $errors['email'] = "email already exists";
        }else if(!filter_var($_POST["email"],FILTER_VALIDATE_FLOAT)){
            $errors['email'] = "email not valid";
        }


        if(empty($_POST["password"])) {
            $errors['password'] = "A password is required";
        }else if(strlen($_POST['password']) < 8){
            $errors['password'] = "password must be 8 character or more";
        }else if($_POST['password'] !== $_POST["confirm_password"]){
            $errors['password'] = "password dont match";
        }


    }

    $data["username"] = $_POST["username"];
    $data["email"] = $_POST["email"];
    $data["role"] = "user";
    $data["password"] = password_hash($_POST["password"],PASSWORD_DEFAULT) ;


    $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";
    run_query($query,$data);
    redirect('login');
}




?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>signup -blog</title>






    <link href="<?php echo ROOT?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="<?php echo ROOT?>/assets/css/signin.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="form-signin w-100 m-auto">
    <form method="post">
        <a href="<?php echo ROOT?>"> <img class="mb-4 rounded-circle shadow" src="<?php echo ROOT?>/assets/images/logo.jpg" alt="" width="99" height="99" style="object-fit: cover"></a>

        <h1 class="h3 mb-3 fw-normal">Please sign up</h1>
        <?php if (!empty($errors)):?>
        <div class="alert-danger">
            Please fix the errors below
        </div>
        <?php endif;?>
        <div class="form-floating">
            <input value="<?=old_value('username')?>" name="username" type="text" class="form-control my-2" id="floatingInput" placeholder="username">
            <label for="floatingInput">User name</label>
        </div>
        <div>
            <?php if (!empty($errors)):?>
            <div class="text-danger"><?=$errors['username'] ?>  </div>
            <?php endif;?>
        </div>

        <div class="form-floating">
            <input value="<?=old_value('email')?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>

        <div>
            <?php if (!empty($errors)):?>
                <div class="text-danger"><?=$errors['email'] ?>  </div>
            <?php endif;?>
        </div>

        <div class="form-floating">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div>
            <?php if (!empty($errors)):?>
                <div class="text-danger"><?=$errors['password'] ?>  </div>
            <?php endif;?>
        </div>
        <div class="form-floating">
            <input name="confirm_password" type="password" class="form-control" id="floatingPassword" placeholder="Password Confirm">
            <label for="floatingPassword">Password Confirm</label>
        </div>
        <div class="my-2">
            already have an account? <a href="<?php echo ROOT?>/login">login here</a>
        </div>
        <div class="checkbox mb-3">
            <label>
                <input name="term" type="checkbox" value="remember-me"> Accept terms and condition
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        <p class="mt-5 mb-3 text-muted">&copy; <?php echo date("Y")?></p>
    </form>
</main>



</body>
</html>

