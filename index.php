<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
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
        <li class="active"><a href="index.php">Browse</a></li>
        <li><a href="upload.php">Upload</a></li>
      </ul>

      <form class="navbar-form navbar-right" role="search" action="index.php" method="POST" enctype="multipart/form-data">
	<div class="form-group input-group">
	<input type="text" name="SearchText" class="form-control" placeholder="Search..">
	<span class="input-group-btn">
	<button type="submit" class="btn btn-default" name="Search" value="Search!">
	<span class="glyphicon glyphicon-search"></span>
	</button>
	</span>    
	</div>
      </form>
      
      
      
    </div>
  </div>
</nav>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Interviews of Veterans</h1>      
    <p>Browse Interviews of Veterans</p>
  </div>
</div>

<div class="container-fluid bg-3 text-center">    
<div class="row">

<?php 
$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ProjectDB";
$conn = mysqli_connect( $servername, $username, $password , $database );
$doshow = FALSE;
$query = "";
if(isset($_POST['Search']))
{
	$SearchText = $_POST['SearchText'];
	$query = "SELECT * FROM VIDEO WHERE VIDEO_TITLE LIKE '%"
		.$SearchText."%' OR TEXT LIKE '%".$SearchText."%'";
}
else
{	
	$query =  "SELECT * FROM VIDEO;";
}
$result = mysqli_query($conn, $query);
	$index = 1;
	while( $row = mysqli_fetch_assoc( $result ) ) {
		$type = "Video";
		if(strpos($row['VIDEO_PATH'],"mp4") === false)
		{
			$type = "Audio";
		}
        $optionalDotDotDot = "";
		$small = substr($row['TEXT'], 0, 50);
        if(strlen($row['TEXT']) > 50) {
            $optionalDotDotDot = "...";
        }
		echo "<div class=\"col-sm-3\" style=\"background-color: #eeeeee; margin: 5px;\">";
		echo "<h3><a href=\"view.php?video_id=".$index. "\">".$row['VIDEO_TITLE']."</a></h3>";
		echo "<video width=\"320\" height=\"240\" style=\"width:100%\" controls><source src=\"".$row['VIDEO_PATH']."\" type=\"video/mp4\">There has been an error.</video>";
		echo "<b>Transcription:</b> ".$small.$optionalDotDotDot."<br>";
		echo "<b>Media Type:</b> ".$type;
		echo "</div>";
		$index = $index + 1;
		}
mysqli_close($conn);
?>
  </div>
</div><br><br>

<footer class="container-fluid text-center" style="background-color: #3c3d41;color: rgba(255,255,255,1.00);">
  <br>
  <p>The Vetranscriber</p>
  <br>
</footer>

</body>
</html>
