<?php
    session_start();
    require "config/config.php";
    $results = [
        "status" => "success",
    ];

    if (!isset($_GET['track_id']) || empty($_GET['track_id'])
	|| !isset($_GET['title']) || empty($_GET['title']) 
    || !isset($_GET['album']) || empty($_GET['album'])
    || !isset($_GET['artist']) || empty($_GET['artist'])
    || !isset($_GET['cover']) || empty($_GET['cover']) ) {
	$results['status'] = "Did not retrieve all the necessary data to favorite this song";
    
    }
    else{
        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ( $mysqli->connect_errno ) {
            $results['status'] = $mysqli->connect_error;
            echo json_encode($results);
            exit();
        }
        $track_id = intval($_GET['track_id']);

        $statement = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $statement->bind_param("s", $_SESSION['username']);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        } 

        // How prepared statement gets results
        $username_results = $statement->get_result();
        $user_id = intval($username_results->fetch_assoc()['id']);
        


        //checking if song has been favorited
        $statement = $mysqli->prepare("SELECT * FROM users_has_songs WHERE users_id = ? AND track_id= ?");
        $statement->bind_param("ii", $user_id, $track_id);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        }
        $statement->store_result();
        $numrows = $statement->num_rows;
        $statement->close();
        if($numrows == 1){
            $results['status'] = "This song has already been favorited";
            echo json_encode($results);
            exit();
        }


        // checking songs table to see if this track alreay exists
        $statement = $mysqli->prepare("SELECT * FROM songs WHERE track_id = ?");
        $statement->bind_param("i", $track_id);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        
        } 


        $song_result = $statement->get_result();
        $count = -1;
        while($row = $song_result->fetch_assoc()){
            $count = $row['count']+1;
        }

       
        if($count === -1){
            //add song to songs table
            $count = 1;

            $statement = $mysqli->prepare("INSERT INTO songs(track_id,title,artists,album,cover,count) VALUES(?,?,?,?,?,?)");
            $statement->bind_param("issssi", $track_id,$_GET['title'],$_GET['artist'],$_GET['album'],$_GET['cover'],$count);
            $executed = $statement->execute();
            if(!$executed) {
                $results['status'] = $mysqli->error;
                echo json_encode($results);
                exit();
            
            } 
        }
        
        else{
            // update song count by adding 1
            $statement = $mysqli->prepare("UPDATE songs SET count = ? WHERE track_id = ?");
            $statement->bind_param("ii",$count, $track_id);
            $executed = $statement->execute();
            if(!$executed) {
                $results['status'] = $mysqli->error;
                echo json_encode($results);
                exit();
            
            } 
        }
        $statement->close();


        // Establishing the favorite relationship
        $statement = $mysqli->prepare("INSERT INTO users_has_songs(users_id,track_id) VALUES (?,?)");
        $statement->bind_param("ii",$user_id,$track_id);
        $executed = $statement->execute();
        if(!$executed) {
            $results['status'] = $mysqli->error;
            echo json_encode($results);
            exit();
        } 
     
        $mysqli->close();

    }

    echo json_encode($results);



?>