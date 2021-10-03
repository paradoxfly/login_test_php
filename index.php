<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="./bootstrap-4.5.0-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap-4.5.0-dist/css/bootstrap-grid.css">

    <title>User Login</title>
</head>
<body class="container-fluid text-center">
    <h1> Welcome to my simple login page</h1>
    <form id="form" method="post" action="index.php" enctype='multipart/form-data' >
    <?php 
        echo <<<_END
        <div class="form-group">
        Username <input type='text' id="username" name="username" class="form-control row" value=$_POST[username]><br>
        Password: <input type='password' id="password" name="password" class="form-control row" value=$_POST[password]><br>
        <button id="button" class="btn btn-sm btn-outline-dark">Log In</button>
        </div>
_END
    ?>
        
        
        <p>
            Do not have an account? <a href="./signup.php">Sign Up</a>
        </p>

    </form>
    <script>
        let FORM = document.getElementById("form")
        let USERNAME = document.getElementById("username")
        let PASSWORD = document.getElementById("password")
        let BUTTON = document.getElementById("button")

        let username = USERNAME.value
        let password = PASSWORD.value

        USERNAME.addEventListener('change', event=>{
            username = event.target.value
        })
        PASSWORD.addEventListener('change', event=>{
            password = event.target.value
        })
        BUTTON.addEventListener('click', event=>{
            event.preventDefault()
            if((username === "")||(password === "")){
                console.log("Must fill both fields")
            } else {
                form.submit()    
            }
        })
    </script>
    <?php
        require_once '../login.php';
        $conn = new mysqli($db_hostname, $db_username, $db_password, 'user_information');
        
        if($conn->connect_error){ 
            die("Unable to connect to MySQL. " . $conn->connect_error);
        }
        $query = "SELECT * FROM login_info";
        if(isset($_POST[username])){
            $result = $conn->query($query);
            $exists = FALSE;
            while($row = $result->fetch_assoc()){
                if($row[username] === $_POST[username]){
                    //echo "Username matches <br>";
                    if($row[password] === $_POST[password]){
                        //echo "Password matches <br>";
                        //Redirect to different page
                        echo "<script>document.location.href = \"./user.php?$_POST[username]\"</script>";
                        $exists = TRUE;
                        break;
                    } else {
                        echo "Password is incorrect";
                        break;
                    }
                }
            }
            if($exists) echo "Username Doesn't Exist";
        }
        
        //print_r($_POST) ;       
    ?>
</body>
</html>