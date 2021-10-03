<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link link rel="stylesheet" type="text/css" href="./bootstrap-4.5.0-dist/css/bootstrap.css">
  <link link rel="stylesheet" type="text/css" href="./bootstrap-4.5.0-dist/css/bootstrap-grid.css">
  <?php 
  $username = strtoupper($_SERVER[QUERY_STRING]);
  echo "<title>$username'S PROFILE</title>";
  ?>
</head>
<body>
  <?php 
    echo "<h3>WELCOME $username</h3>";

    require_once '../login.php';
    $conn = new mysqli($db_hostname, $db_username, $db_password, 'user_information');
    if($conn->connect_error){ 
        die("Unable to connect to MySQL. " . $conn->connect_error);
    }

    //Fetch id key of user's database info
    $query = "SELECT * FROM login_info";
    $result = $conn->query($query);
    $id = 0;
    while($row = $result->fetch_assoc()){
      if($row[username] == $_SERVER[QUERY_STRING]){
        $id = $row[id];
        //echo "Found an id match";
        break;
      } else{
        //echo "No match";
      }
    }

    //Use id key to fetch rest of their data
    $query = "SELECT * FROM user_info";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
      if ($row[id] == $id){
        echo <<<_END
        <h4>YOUR AGE: $row[age] YEARS</h4>
        <h4>YOUR HEIGHT: $row[height] CENTIMETERS</h4>
        <h4>YOUR WEIGHT: $row[weight] KILOGRAMS</h4>
  _END;
        break;
      }
    }

  ?>
</body>
</html>