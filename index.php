<?php 
session_start();
require "config/config.php";
$_GET['page'] = 'index.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <title>Home</title>
</head>
<body>
    <div id="home">
        <?php include 'nav.php';?>


        <div class="card vh-100 bg-dark text-white">
            <img class="card-img vh-100" src="https://images.unsplash.com/photo-1501612780327-45045538702b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8bXVzaWN8ZW58MHx8MHxibGFja19hbmRfd2hpdGV8&auto=format&fit=crop&w=800&q=60" alt="Card Image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <div class="w-50 text-center landing">
                    <p class="h1 p-2">Welcome to Sing Along</p>
                    <p class="h4 p-2">Find lyrics to sing along</p>
                    <a href="search.php" class="btn btn-outline-light btn-lg">Search</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>