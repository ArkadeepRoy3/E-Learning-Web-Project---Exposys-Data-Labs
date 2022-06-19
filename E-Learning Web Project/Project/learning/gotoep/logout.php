<?php
        
        session_start();
        // did the user browser set the cookie
        if(isset($_COOKIE[session_name() ])){
           //empty the cooki
           setcookie( session_name(), '' ,time()-8640,'/' ); 
        }
        
        
            
        // clear all session variables
        session_unset();
        $_SESSION[]=array();
        
        // destroy the session
        session_destroy();
        
        header("Location: index.php");
?>