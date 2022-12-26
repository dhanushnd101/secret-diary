<?php
    session_start();
    if (array_key_exists("id", $_COOKIE )){
        $_SESSION["id"] = $_COOKIE["id"];
    }
    if(array_key_exists("id",$_SESSION)){
        echo "<p>LogedIn! <a href='index.php?Logout=1'> LogOut </a></p>";
    }else{
        header("Location:index.php");
    }
    include("header.php");
?>   
    <div class="container-fluid">
        
        <textarea  id="diary" class ="form-controle" > 
            
            
        </textarea>
        
    </div>
  
    
<?php  
    include("footer.php")
?>