<?php
   
    $host = 'localhost'; //localhost ; 127.0.0.1
    $user = 'root';
    $passw = '';
    $db = 'db_parkir';
    
    $conn = mysqli_connect($host,$user,$passw,$db);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else{
        echo "<script type='text/javascript'>
            alert('DB successfully connected');
            setTimeout(function() {
                // Close the alert after 1 second (This won't work with default alert)
                window.location.reload(); // Optionally reload the page after closing
            }, 1000);
          </script>";
        
    }
    
  
    
    function myquery($query){
        global $conn;
    
        $result = mysqli_query($conn,$query);
    
        $list = [];
    
        while ($data = mysqli_fetch_assoc($result)) {
           $list[] = $data;
    
         }
        return $list;
    }
    
    
   
 
?>