<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link link rel="stylesheet" type="text/css" href="./bootstrap-4.5.0-dist/css/bootstrap.css">
    <link link rel="stylesheet" type="text/css" href="./bootstrap-4.5.0-dist/css/bootstrap-grid.css">

    <title>SIGN UP</title>
</head>
<body class="text-center">
    <h1>You Sign Up Here</h1>
    <form method='post' action='signup.php' enctype='multipart/form-data'>
        <div class = "form-group">
            Username: <input type='text' name='username' class="form-control row"><br>
            Password: <input type='password' name='password' class="form-control row"><br>
            Confirm Password: <input type='password' name='conf_password' class="form-control row"><br>
            Age: <input type='number' name='age' class="form-control row"><br>
            Weight(kg): <input type='number' name='weight' class="form-control row"><br>
            Height(cm): <input type='number' name='height' class="form-control row"><br><br>

            <input type='submit' value='Create Profile'><br>
        </div>
    </form>
    <?php
        require_once '../login.php';
        $conn = new mysqli($db_hostname, $db_username, $db_password, 'user_information');
        
        if($conn->connect_error){ 
            die("Unable to connect to MySQL. " . $conn->connect_error);
        }


        if($_POST){
            if(($_POST[username] == '')||($_POST[password] == '')||($_POST[conf_password] == '')||($_POST[age] == '')||($_POST[weight] == '')||($_POST[height] == '')){
                echo 'Can\'t leave any fields empty';
            } elseif($_POST[password] != $_POST[conf_password]){
                echo 'Both passwords do not match. Please correct this.';
            } elseif(username_exists($conn, $_POST[username])) {
                echo 'Username already exists. Pick a different username';
            } else {
                $login_query = "INSERT INTO login_info (username, password) VALUES ('$_POST[username]', '$_POST[password]')";
                $info_query = "INSERT INTO user_info (age, weight, height) VALUES ('$_POST[age]', '$_POST[weight]', '$_POST[height]')";
                // $result1 = $conn->query($login_query);
                // $result = $conn->query($info_query);
                if($conn->query($login_query) === TRUE){
                    if($conn->query($info_query) === TRUE){
                        echo "Successfully created profile";
                    } else{
                        echo "UserInfo unsuccessfully uploaded";
                    }
                } else {
                    echo "Upload failed";
                }
                
            }
        }

        function username_exists($connection, $username){
            //echo "got here <br>";
            $query = "SELECT username FROM login_info";
            $result = $connection->query($query);
            //print_r($result);
            $check = 0;
            while($row = $result->fetch_assoc()){
                if($row[username] == $username){
                    $check = 1;
                    return TRUE;
                    break;
                } else return FALSE;
            }
        }
    ?>
</body>
</html>