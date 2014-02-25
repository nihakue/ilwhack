<?php

/* -- DOCUMENTATION --
add_speech(politician_name,topic_name,date,mood); creates speech with given politician_id, topic_name, date and mood
*/

if ($_POST['passkey'] == "21CiuhJ3S5lk1EjWhlkCjWhdo98Xji56Gh2jkh5nHhqgkjERYhaygdsX0f9SD87yasfiHTEKJHQEKQJWEGUIHZ")
{   
    include 'dbconnect.php';
 
    //add_speech(politician_name,topic_name,date,mood);
    function add_speech($politician_name,$topic_name,$date,$mood)
    {
        $result = mysql_query("INSERT INTO temachmaga_speech (`politician_name`, `topic_name`, `date`, `mood`) VALUES ('$politician_name','$topic_name','$date','$mood')");
        if ($result)
        {
            return 1;
        }
        else
        {
            echo mysql_error();
            return -1;
        }
    }    
    
    //actual request
    if ($_POST['action'] == "add_speech")
    {
        $politician_name = $_POST['politician_name'];
        $topic_name = $_POST['topic_name'];
        $date = $_POST['date'];
        $mood = $_POST['mood'];
        add_speech($politician_name,$topic_name,$date,$mood);
    }    
}
//echo add_speech("George Adam", "some fuzzy cloud", "20 february 1992", 91);
?>