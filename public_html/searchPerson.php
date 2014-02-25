<?php

    session_start();
    
    /*
    function secureMe($input)
    {
        if (get_magic_quotes_gpc()==0)
        {
            return $input;
        }
        else
        {
            return ($input);
        }
    }
    */
    
    if (isset($_POST['name']))
    {
        //take input
        $input = ($_POST['name']);
        //define what to search for based on input
        $search="name"; //UPDATE FOR LATER: option to base $search on $input -> party, representing, etc.
        
        include 'dbconnect.php';
        $sql = mysql_query("SELECT COUNT(*) FROM temachmaga_politicians WHERE name='$input' OR party='$input' OR representing='$input'");
        $sql = mysql_fetch_assoc($sql);
        /*
        echo "SELECT COUNT(*) FROM temachmaga_politicians WHERE ".$search."='".$input."'<br/>";
        echo mysql_error();
        echo "<br/>".$sql['COUNT(*)'];
        */
        
        if ($sql['COUNT(*)'] > 0)
        {
            //$result = mysql_query("SELECT * FROM temachmaga_politicians WHERE $search='$input'");
            $_SESSION['result'] = "SELECT * FROM temachmaga_politicians WHERE name='$input' OR party='$input' OR representing='$input'"; //returns array
        }
        else
        {
            $_SESSION['result']="notfound";
        }
        
    }
    header('location:index.php')
?>