<?php
    session_start();
    $error = "";
    $a1="";
    if(array_key_exists("Logout",$_GET)){
        unset($_SESSION);
        setcookie("id","", time() - 60*60);
        $_COOKIE["id"]="";
        
    }else if((array_key_exists("id",$_SESSION) AND $_SESSION["id"]) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
        header("Location:lodedinpage.php");
    }
    
    include("link.php");
    
    if(array_key_exists('email',$_POST) or array_key_exists('pass', $_POST)){

        if($_POST['email'] == ''){
            
            $error .= "<p>The email is required *</p>";
        }
        else if($_POST['pass'] == ''){
            echo "wow";
            $error .= "<p>The pass is required *</p>";
        }
        else{
            
            if($_POST["signUp"] == 1){
                
                
                
                $query ="SELECT id FROM users WHERE email= '". mysqli_real_escape_string($link,$_POST['email'])."'"; 
                $result = mysqli_query($link,$query);
                
                if(mysqli_num_rows($result)>0 ){
                    $error .= "<p>The email add has already taken</p>";
                }else{
                    $query = "INSERT INTO users (email,pass) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['pass'])."')";
                   if (!mysqli_query($link,$query)){
                       $error .= "<p> There was a problem in SignUp - please try again</p>";
                       
                       
                   }else{
                       $query = "UPDATE users SET pass = '".md5(md5(mysqli_insert_id($link)).$_POST['pass'])."'WHERE id = ".mysqli_insert_id($link);
                       mysqli_query($link,$query);
                       $_SESSION['id']= mysqli_insert_id($link);
                       $a1 =  $query;
                       if($_POST['stayLogedIn'] == '1'){
                           setcookie("id",mysqli_insert_id($link), time() + 60*60*24);
                       }
                       header("Location:lodedinpage.php");
                       
                   }
                }
            }else{
                
                $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";
                $result = mysqli_query($link,$query);
                $row = mysqli_fetch_array($result);
                if(isset($row)){
                    $hashedpass = md5(md5($row["id"]).$_POST["pass"]);
                    
                    if($hashedpass == $row["pass"]){
                        
                        $_SESSION["id"] = $_row["id"];
                        
                        if($_POST['stayLoggedIn'] == '1'){
                          
                           setcookie("id",$row["id"], time() + 60*60*24);
                       }
                      
                       header("Location:lodedinpage.php");
                    }else{
                    
                    $error = "<p> That E-Mail/Password could not be found.";
                    
                    }
                }
                
                
                
                
                
            }
        }
        
    }

?>

<?php include("header.php"); ?>


    <div class="container" id="homePagrContainer">
        <h1>Secret Diary</h1>
        <p><strong>Each new day is a blank page in the diary of your life</strong></p>
        
        
        <form method ="post" id="signUpForm">
            <p> <h5>Create an account It's quick and easy.</h5></p>
            <fieldset class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email">
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control" type="password" name="pass" placeholder="Password">
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control" type="hidden" name="signUp" value="1">
                 <div class="form-group row">
                    <div class="col-sm-10">
                      <div class="form-check">
                         <input  class="form-check-input"   type="checkbox" name="stayLoggedIn" value=1>
                        <label class="form-check-label" for="gridCheck1">
                          stay logged in
                        </label>
                      </div>
                    </div>
                  </div>
            </fieldset>
            <fieldset class="form-group">
                <button type="submit" class="btn btn-success">Sign In </button>
            </fieldset>
            <p> <a class="toggleForm">Log In</a></p>
            <div class="alert alert-danger" role="alert">
                <?php echo $error;  ?>
            </div>
                
        </form>
    
        <form method ="post" id="logInForm">
            <p> <h5>Login using username and password</h5></p>
            <fieldset class="form-group">
                <input class="form-control" type="email"  name="email" placeholder="Email">
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control" type="password"  name="pass" placeholder="Password">
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control" type="hidden" name="signUp" value="0">
                  <div class="form-group row">
                    <div class="col-sm-10">
                      <div class="form-check">
                         <input class="form-check-input"  type="checkbox" name="stayLoggedIn" value=1>
                        <label class="form-check-label" for="gridCheck1">
                          stay logged in
                        </label>
                      </div>
                    </div>
                  </div>
            </fieldset>
            <fieldset class="form-group">
                <button type="submit" class="btn btn-success">Log In</button>
            </fieldset>
            <p> <a class="toggleForm">Sign Up</a></p>
                 <div class="alert alert-danger" role="alert">
                    <?php echo $error;  ?>
                 </div>
        </form>
    </div>
    
    
<?php include("footer.php"); ?>
    
    
   
