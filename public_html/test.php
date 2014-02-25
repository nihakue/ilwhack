<meta charset="UTF-8">

<?php
	include 'dbconnect.php';
	
	
	
	
/* STRUCTURE
msps = {
    'name': name
    'awl': average word length
    'ttn': top ten nouns
    'ttv': top ten verbs
    'overall_mood': overall mood
}

speeches = {
    'name': name
    'topic': topic
    'date': date
    'speech' speech text
    'mood': name's mood within the speech
}
*/
	$name = "George Adam";
	$speech = $speeches->find(array("name" => $name));
	$msp = $msps->find(array("name" => $name));
	
	
	foreach($msp as $person)
	{
		echo "<b>".$person['name'] . "</b><br/>";
		
		echo "<b>Overall mood:</b> ".(round(100*$person['overall_mood'])/100)."<br/>";
		echo "<b>Average word length:</b> ".(round(100*$person['awl'])/100)."<br/>";
		
		echo "<b>Top Ten Nouns:</b><br/>";
		foreach($person['ttn'] as $x)
		{
			echo "word: ".$x[0]." - ".$x[1]."<br/>";
		}
		
		echo "<b>Top Ten Verbs</b>:<br/>";
		foreach($person['ttv'] as $x)
		{
			echo "word: ".$x[0]." - ".$x[1]."<br/>";
		}
	}
	
	echo "<br/><br/>";
	
	// iterate through the results
	foreach ($speech as $document) {
	    //name
	    echo "<b>".$document['name'] . "</b> - ".$document['date'].":<br/>";
	    //topic
	    echo $document["topic"] . "<br/>";
	    //mood
	    echo "mood: ".$document["mood"] . "<br/>";
	    //content
	    echo $document["speech"] . ":<br/>";
	}

?>