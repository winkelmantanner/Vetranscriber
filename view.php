<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">VeTranscriber</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Browse</a></li>
        <li><a class="active" href="upload.php">Upload</a></li>
      </ul>
      
      
      
    </div>
  </div>
</nav>

</head>

<body>

<?php
$video_id = $_GET["video_id"];

$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ProjectDB";
    
    $conn = mysqli_connect( $servername, $username, $password, $database );
    $result = mysqli_query( $conn, "SELECT * FROM VIDEO WHERE VIDEO_ID=" . $video_id . "");
    $row = mysqli_fetch_assoc( $result );
    echo "<h1>Viewing ".$row['VIDEO_TITLE']."</h1>";
    echo "<video width=\"320\" height=\"240\" controls><source src=\"".$row['VIDEO_PATH']."\" type=\"video/mp4\">Your browser does not support the video tag.</video>";
    echo "<h3>Transcription:</h3>";
    echo "<p>".$row['TEXT']."</p>";
?>

</body>
</html>