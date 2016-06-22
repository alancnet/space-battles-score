	<?php
$host=getenv("MYSQL_HOST");
$user=getenv("MYSQL_USER");
$password=getenv("MYSQL_PASSWORD");
$database=getenv("MYSQL_DATABASE");

$con = mysqli_connect($host, $user, $password, $database); // connect to database

// check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$myName = $_GET["name"]; // get user's name from url
$myScore = intval($_GET['score']); // get the user's score from the url
$Auth = $_GET["auth"]; // get the user's auth code from the url

$salt = getenv("SCORE_SALT"); // secret salt, ensure it matches the salt found in GM
$lim = 10; // max number of score entries to show

// create array to hold values for the names and scores of the top 10
for($i=0;$i<$lim;$i++){
  $Name[$i] = "";
  $Score[$i] = 0;
}

  $result = mysqli_query($con,"SELECT * FROM Hiscores ORDER BY Score DESC LIMIT $lim") or die(mysqli_error($con)); // pull data from table

  $ii = 0;
  // if there are results, display them
  if ($result!=""){ 
    while($row = mysqli_fetch_array($result)){
          $Score[$ii] = intval($row['Score']); // get results from score
          $Name[$ii] = ($row['Name']); // get results for name
          $ii+=1;
    }
  }

$verify = md5(mb_convert_encoding($myName.$myScore.$salt, "UTF-8")); // ensure verification matches in GM

$success = "2"; // default success

// update database table
$sql = "REPLACE INTO Hiscores (Name, Score)
VALUES ('$myName', '$myScore')";

if ($myScore > 0) { // check if score exists
  if (strcmp($Auth, $verify) === 0) {
    // if the results were successfully added to the database, echo either true or false (1 or 0)
    if ($con->query($sql) === TRUE) {
      $success = "1";
    }
    else{
      $success = "0";
    }
  }
  else{
    $success = "2"; // invalid auth
  }
  $result = mysqli_query($con,"SELECT * FROM Hiscores ORDER BY Score DESC") or die(mysqli_error($con)); // pull data from table

  $ii = 0;
  // if there are results, display them
  if ($result!=""){ 
    while($row = mysqli_fetch_array($result)){
          $Score[$ii] = intval($row['Score']); // get results from score
          $Name[$ii] = ($row['Name']); // get results for name
          $ii+=1;
    }
  }

}

else{
  $success = "3"; // no score, just browsing
}

echo "<success>".$success."</success><br>";

for($i = 0; $i < $lim; $i++){
  echo "<name".$i.">".$Name[$i]."</name".$i."><score".$i.">".$Score[$i]."</score".$i."><br>";  
}


mysqli_close($con); // close the connection
?>