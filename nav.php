<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Sing Along</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                
                <li class="nav-item">
                <a class="nav-link  <?php if($_GET['page'] === 'index.php'){echo "active";} ?>" aria-current="page" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                <a class="nav-link  <?php if($_GET['page'] === 'search.php'){echo "active";} ?>" aria-current="page" href="search.php">Search</a>
                </li>

                
            </ul>

            
            <ul class="navbar-nav">
                <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"] || $_GET['page'] === 'logout.php'): ?>
                    <li class="nav-item">

                    <a class="nav-link  <?php if($_GET['page'] === 'signUp.php'){echo "active";} ?>" aria-current="page" href="signUp.php">Sign Up</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link  <?php if($_GET['page'] === 'login.php'){echo "active";} ?>" aria-current="page" href="login.php">Login</a>
                    </li>
                <?php else: ?>
                    
    
                    <li class="nav-item"><div class="nav-link">Hello <?php echo $_SESSION["username"]; ?></div></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <li class="nav-item"><a class="nav-link <?php if($_GET['page'] === 'favorites.php'){echo "active";} ?>" href="favorites.php">Favorites</a></li>
                    
                
			        
                    

                <?php endif; ?>

                
            </ul>

           
           
        </div>

       
    </div>
    
</nav>

