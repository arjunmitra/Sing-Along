<?php 
    session_start();
    require "config/config.php";
    $_GET['page'] = 'favorites.php';
    // // var_dump($_SESSION);


    // getting songs
    if (!isset($_SESSION['logged_in']) || empty($_SESSION['logged_in'])){
        $error = "you are not logged in";
        
    }
    else{
        
        
        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ( $mysqli->connect_errno ) {
            $results['status'] = $mysqli->connect_error;
            echo json_encode($results);
            exit();
        }

        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bind_param("s", $_SESSION['username']);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        } 
        $username_results = $statement->get_result();
        $user_id = intval($username_results->fetch_assoc()['id']);



        $statement = $mysqli->prepare("SELECT * FROM users_has_songs WHERE users_id = ?");
        $statement->bind_param("i", $user_id);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        }
        

        $results = $statement->get_result();
        $track_id_array = [];
        while($row = $results->fetch_assoc()) {
            array_push($track_id_array, $row['track_id']);
        }

        $songs_detail_array = [];
        foreach ($track_id_array as $track_id) {
            $track_id = intval($track_id);
            $statement = $mysqli->prepare("SELECT * FROM songs WHERE track_id = ?");
            $statement->bind_param("i", $track_id);
            $executed = $statement->execute();
            if(!$executed) {
                $error = "could not find song in database";
                exit();
            }
            $song_result = $statement->get_result();
            $song_details = $song_result->fetch_assoc();
            array_push($songs_detail_array, $song_details);
            // var_dump($song_details);

            
            
        }

        // var_dump($songs_detail_array);


     
        $statement->close();

        $mysqli->close();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
</head>
<body>
    <?php include 'nav.php';?>
    <div class="container">
        
        <div class="p-5 vh-75 d-flex justify-content-center align-items-center text-center search-area">
            <div class="pt-5">
                <p class="h1 p-5">Find Your Favorite Songs</p>
                
            
            </div>
            
        </div>

        

        <div class="song-list">

            
            <div class="song-list">
            <?php if(isset($error) || !empty($error)):?>
                <div>You have no favorite songs saved</div>
            <?php else: ?>

                <?php foreach ($songs_detail_array as $song_details):?>
                    
                    <form method="GET" action="song.php">
                        <div class="card text-white bg-dark mb-3 mx-auto song-items"  id="search-card">
                        <div class="card-header h1 text-center song-title"><?php echo $song_details['title']?></div>
                        <div class="card-body text-center">
                        <h5 class="card-text">Album: <?php echo $song_details['album']?></h5>
                        <h5 class="card-text">Artist: <?php echo $song_details['artists']?></h5>
                        <input type="hidden" class="track" name="track_id" value="<?php echo $song_details['track_id']?>">
                        <input type="hidden" name="title" value="<?php echo $song_details['title']?>">
                        <input type="hidden" name="album" value="<?php echo $song_details['album']?>">
                        <input type="hidden" name="artist" value="<?php echo $song_details['artists']?>">
                        <button type="submit" class="btn btn-outline-light btn-lg">Get Details</button>
                        <button type="button" data-track = "<?php echo $song_details['track_id']?>"class="btn btn-outline-warning btn-lg remove-btn">Remove Favorite</button>
                        </div>
                        </div>
                    </form>
                    
                <?php endforeach; ?>


            <?php endif; ?>




    </div>


        </div>


    </div>
    
   
  
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        
       // do jquery ajax call here 

        $( ".remove-btn" ).on( "click", function() {
            console.log("in remove");
            console.log($(this).parent().parent());
            console.log($(this).data("track"));
            let $parent = $(this).parent().parent();
            $.get( "remove.php", { track_id: $(this).data("track") } )
            .done(function( data ) {
                console.log("returned from remove.php");
                console.log(data);
                let convertedResults = JSON.parse(data);
                if(convertedResults["status"] === "success"){
                    //delete card
                    // console.log($(this).parent().parent());
                    $parent.fadeOut();
                }
                else{
                    // indicate error
                    alert("there was an error removing this song as a favorite. Here is the error: " + convertedResults["status"]);
                }
            });

        });
    </script>
    
</body>
</html>