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
        <li><a href="index.php">Browse</a></li>
        <li><a class="active" href="upload.php">Upload</a></li>
      </ul>
      
      
      
    </div>
  </div>
</nav>
</head>



<?php
	$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ProjectDB";
    
    $conn = mysqli_connect( $servername, $username, $password );
    
    if( !$conn )
    {
        die("Connection failed: " . mysqli_connect_error());
    }else{
        
    }
    
    
    if( mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS ".$database) )
    {
        //echo "Database CHECK<br>";
    }else{
        echo "Error with high scores database: " . mysqli_error( $conn ) . "<br>";
    }
    
    mysqli_close($conn);
    
    
      $conn = mysqli_connect( $servername, $username, $password, $database );
    
    
    if( mysqli_query($conn, "CREATE TABLE IF NOT EXISTS VIDEO( VIDEO_ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, VIDEO_PATH VARCHAR(1000), TEXT VARCHAR(1000), VIDEO_TITLE VARCHAR(1000) , VIDEO_CONFIDENCE DECIMAL(5,5)  )") ){
        //echo "T CHECK<br>";
    }else{
        echo "Error with high scores tables: " . mysqli_error($conn) . "<br>";
    }
    
     $conn = mysqli_connect( $servername, $username, $password, $database );
     $result = mysqli_query($conn, "SELECT * FROM VIDEO;");
     $rowcount=mysqli_num_rows($result);
     
    if( $rowcount > -1 ){
        //echo "T CHECK<br>";
    }else{
        echo "Error with high scores tables: " . mysqli_error($conn) . "<br>";
    }
    $nextrow = $rowcount + 1;
    mysqli_close($conn);
	$conn = mysqli_connect( $servername, $username, $password , $database );
	
	if(isset($_POST['submit']))
	{
		$name = $_FILES['file']['name'];
		$title = $_POST['title'];
		$temp = $_FILES['file']['tmp_name'];
		
		$query = "INSERT INTO VIDEO (VIDEO_PATH, VIDEO_TITLE, TEXT) VALUES( 'uploaded/$nextrow/$name' , '$title' , 'empty' )";
		mysqli_query( $conn, $query);
		
		mkdir ( "uploaded/$nextrow" ) ;
		move_uploaded_file($temp,"uploaded/$nextrow/".$name);
	}
	mysqli_close($conn);
?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="file" />
	<input type="text" name="title"><br>
	<input type="submit" name="submit" value="Upload!" />
</form>

</body>
</html>