<?php 
    session_start();
    require "config/config.php";
    
    
?>
<?php $_GET['page'] = '';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="song.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
</head>
<body>
    <?php include 'nav.php';?>


    <div class="card text-white bg-dark mb-3 text-center mx-auto pt-5" id="song-card" >
    
        <div class="card-header h2"><?php echo $_GET['title'] ?></div>
        <div class="card-body">
        <p class="h5 card-header pt-2">Album: <?php echo $_GET['album'] ?>, Artist: <?php echo $_GET['artist'] ?></p>
        <p class="card-text pt-2 h3" id=lyrics-text>Sorry. Lyrics are unavailable</p>
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-outline-light btn-lg">Back</a>
        <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] ): ?>
            <button type="button" id="favorite" class="btn btn-outline-primary btn-lg">Favorite</button>
        <?php endif; ?>
        </div>
    </div>



    <script>
        let prefix = "https://cors-anywhere.herokuapp.com/";
        let endpoint_lyrics = prefix+"http://api.musixmatch.com/ws/1.1/track.lyrics.get?track_id=" + "<?php echo $_GET['track_id']?>"+ "&apikey=" + "<?php echo API_KEY?>" ;
        let endpoint_img = "https://itunes.apple.com/search?term="+ "<?php echo $_GET['title']?>" + " "+ "<?php echo $_GET['artist']?>"+ "&limit=1";
        ajaxRequest(endpoint_lyrics,displayResults);
        ajaxRequest(endpoint_img,displayImg);

        function ajaxRequest(endpoint, returnFunction) {
        
            let httpRequest = new XMLHttpRequest();
            httpRequest.open("GET", endpoint);
            
            httpRequest.send();

            httpRequest.onreadystatechange = function() {
                
            
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

    function displayResults(songData){
        
        let convertedLyrics = JSON.parse(songData);
        let lyrics = convertedLyrics.message.body.lyrics.lyrics_body;
        document.querySelector(".card-text").innerText = lyrics;
    }

    function displayImg(imgData){
        console.log("in display img");
        let convertedImg = JSON.parse(imgData);
        
        let imgUrl = convertedImg.results[0].artworkUrl100;
        $('body').css('background', 'url(' + imgUrl + ')');

    }



    </script>

    <script>
        document.querySelector("#favorite").onclick = function(event){
            let track_id = "<?php echo $_GET['track_id'] ?>";
            let title = "<?php echo $_GET['title'] ?>";
            let artist = "<?php echo $_GET['artist'] ?>";
            let album = "<?php echo $_GET['album'] ?>";
            let bi = $('body').css("background-image");
            let cover = bi.split(/"/)[1];

            ajaxGet("favoriteBackend.php?track_id="+track_id+"&title="+title + "&artist="+artist + "&album="+album + "&cover="+cover,function(results){
                console.log(results);
                let convertedResults = JSON.parse(results);
                console.log(convertedResults['status']);
                if(convertedResults['status'] ==="success"){
                    // console.log("good");
                    alert("your song was favorited successfully");
                }
                else{
                    alert("could not favorite this song. Here is the error: " + convertedResults['status']);
                }

            });
            
            


        }

        function ajaxGet(endpointUrl, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', endpointUrl, true);
			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						// When ajax call is complete, call this function, pass a string with the response
						returnFunction( xhr.responseText );
					} else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send();
		};


    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>