<?php 
    session_start();
    require "config/config.php";
?>
<?php $_GET['page'] = 'search.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
    
    <title>Search</title>
</head>
<body>
    
    <?php include 'nav.php';?>
    <div class="container">
        <form action="search.php" method="GET" id="search-form">
            <div class="p-5 vh-75 d-flex justify-content-center align-items-center text-center search-area">
                <div class="pt-5">
                    <p class="h1 p-5">Find Your Favourite Songs</p>
                    <div class="input-group input-group-lg">
                        <input type="search" class="form-control" name="search" id="search-input" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-outline-primary">Enter</button>
                    </div>
                
                </div>
                
            </div>

        </form>

        <div class="song-list">


        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>

    function ajaxRequest(endpoint, returnFunction) {
    
        let httpRequest = new XMLHttpRequest();
        httpRequest.open("GET", endpoint);
        
        httpRequest.send();

        httpRequest.onreadystatechange = function() {
            
            console.log("got a response!!!");
            console.log(httpRequest.readyState);
            if(httpRequest.readyState == 4) {
                
                if(httpRequest.status == 200) {
                
                    returnFunction(httpRequest.responseText);
                    

                }
                else {
                    console.log("AJAX error!");
                    console.log(httpRequest.status);
                    console.log(httpRequest);
                }
            }
        }

        console.log("moving along...");
    }

    function displayResults(data){
        let convertedResults = JSON.parse(data);
        
        let parent = document.querySelector(".song-list");
        while(parent.hasChildNodes()) {
        parent.removeChild( parent.lastChild);
    }
        
        for( let i = 0; i <convertedResults.message.body.track_list.length; i++ ){
            let trackID=convertedResults.message.body.track_list[i].track.track_id;
            let commontrackID = convertedResults.message.body.track_list[i].track.commontrack_id; 
 
            let htmlString = `
            <form method="GET" action="song.php">
                <div class="card text-white bg-dark mb-3 mx-auto song-items" data-trackID=${trackID} id="search-card">
                <div class="card-header h1 text-center song-title">${convertedResults.message.body.track_list[i].track.track_name}</div>
                <div class="card-body text-center">
                <h5 class="card-text">Album: ${convertedResults.message.body.track_list[i].track.album_name}</h5>
                <h5 class="card-text">Artist: ${convertedResults.message.body.track_list[i].track.artist_name}</h5>
                <input type="hidden" name="track_id" value="${trackID}">
                <input type="hidden" name="title" value="${convertedResults.message.body.track_list[i].track.track_name}">
                <input type="hidden" name="album" value="${convertedResults.message.body.track_list[i].track.album_name}">
                <input type="hidden" name="artist" value="${convertedResults.message.body.track_list[i].track.artist_name}">
                <input type="hidden" name="album_id" value="${convertedResults.message.body.track_list[i].track.album_id}">
                <button type="submit" class="btn btn-outline-light btn-lg">Get Details</button>
                </div>
                </div>
            </form>
            `;
           
            parent.innerHTML+= htmlString;
        }
       
    
    }


    document.querySelector("#search-form").onsubmit = function(event) {
        event.preventDefault();
        let searchInput = document.querySelector("#search-input").value.trim();
        console.log(searchInput);
        let prefix = "https://cors-anywhere.herokuapp.com/";
        let endpoint = prefix+"http://api.musixmatch.com/ws/1.1/track.search?apikey=" + "<?php echo API_KEY?>"+ "&q_track=" +encodeURIComponent(searchInput) + "&s_artist_rating=desc" ;
        console.log("endpoint: " + endpoint);
        ajaxRequest(endpoint,displayResults);

    }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</body>
</html>