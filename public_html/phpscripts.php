<?php

/* FORMATS :: INSERTING_TOPICS (provided by Manas)
INSERT INTO temachmaga_topic (`topic_id` ,`topic_name` ,`topic_url` ,`content`) VALUES 
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
...
...
...
('i', 'topic_name', 'topic_url', 'topic_content');



*/
include 'dbconnect.php';

//load topics from database and calculate and write in moods etc
function load_topic()
{
    $sql = mysql_query("SELECT * FROM temachmaga_topic");
    while ($rows = mysql_fetch_array($sql))
    {
        
        //iterate through all the topics individually
    	//SPLIT INTO SUBPARTS PER SPEAKER
    		//SUBPART: identify speaker and calculate mood
    		politician_speech($politician_name, $rows['topic_name'], $mood);
    }
}

//inserts entries into database given a politician name, topic name and according mood
function politician_speech($politician_name, $topicname, $mood)
{
    //find proper topic_id related to the topic_name given
	$topic_id = mysql_fetch_assoc(mysql_query("SELECT topic_id FROM temachmaga_topic WHERE topic_name='$name_from_topic'"));
	
	//find proper politician_id related to the speaker
	$politician_id = mysql_fetch_assoc(mysql_query("SELECT id FROM temachmaga_politicians WHERE name='$politician_name'");

	//insert into db	
	mysql_query("INSERT INTO temachmaga_politician_topic (`politician_id` ,`topic_id` ,`mood`) VALUES ('$politician_id','$topic_id','$mood')");
}

///////////////////////////////////////////
function get_politician_id($name)
{
    $result = mysql_fetch_assoc(mysql_query("SELECT id FROM temachmaga_politicians WHERE name='$name'"));
    if ($result['id'])
    {
        return $result['id'];
    }
    else
    {
        return "-1";
    }
}

echo 

/*
HashMap<MSP name, Topic list>

Topic = (Topic name, Speeches list)
Speech = (Date, speech text)

___
the hashmap: does this give a list of topics the MSP is active in?
filter on MSP

write hashmap into database..




$sql = mysql_query("SELECT name FROM temachmaga_politicians");
while ($rows = mysql_fetch_array($sql))
{
    //INSERT TOPIC_NAME+SPEAKER_NAME CONNECTION INTO DB
	for ($i=0; $i<$sizeOf($topic_list); $i++)
	{
		politician_speech($name, $topic_list[$i], 0)
	}

	//INSERT TOPIC INTO DB
	for ($i=0; $i<sizeOf($speeches_list); $i++)
	{
		insert_speech($topicname, $speeches_list[$i])
	}

	//INSERT SPEECH INTO DB
	$sql = mysql_query("SELECT * FROM temachmaga_politician_topic");
	while ($rows = mysql_fetch_array($sql))
	{
		mysql_query(INSERT INTO temachmaga_speech ('speech_id', 'date', 'content') VALUES ('$rows[speech_id]','$date','$content'));
	}

	$rows['name']; //<- we have this one, how do we fetch the list of topics from this?
	//receive TOPIC_LIST from hashmap on key=$rows['name'];
	
	while ($topic=
}
*/

/*
INSERT INTO  `aidanlab_co_uk`.`temachmaga_topic` (`topic_id` ,`topic_name` ,`topic_url` ,`content`) VALUES 
('2',  'topic name',  'topic_url.com',  'awegawg agji a goijw egoia gjklhlkzxnb erawt'), 
('3',  'name 2 of this topic',  'anotherurl.com',  'atiouy sjghzxklcvyzxiouy wetqbqmwnt bmasdbiouzxycv');

INSERT INTO temachmaga_topic (`topic_id` ,`topic_name` ,`topic_url` ,`content`) VALUES 
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
('i', 'topic_name', 'topic_url', 'topic_content'),
...
...
...
('i', 'topic_name', 'topic_url', 'topic_content');

topic_content = whole textfile ...
we insert the entire topic stuff, then from there we can load each topic_content from the database and run scripts to 
split it into separate parts with separate speakers and their moods accordingly. when having this, use the php function politician_speech($politician_name, $topicname, $mood) to insert it.

_____________

$sql = mysql_query("SELECT * FROM temachmaga_topic");
while ($rows = mysql_fetch_array($sql))
{
    //iterate through all the topics individually
	//SPLIT INTO SUBPARTS PER SPEAKER
		//SUBPART: identify speaker and calculate mood
		politician_speech($politician_name, $rows['topic_name'], $mood);
}
_______________________________________

INSERT INTO  `aidanlab_co_uk`.`temachmaga_politician_topic` (
`report_id` ,
`politician_id` ,
`topic_id` ,
`mood`
)
VALUES 
('3',  '0',  '2',  '7'), 
('4',  '2',  '3',  '4');

('report_id','politician_id','topic_id','mood'),
('report_id','politician_id','topic_id','mood'),
('report_id','politician_id','topic_id','mood'),
('report_id','politician_id','topic_id','mood'),
('report_id','politician_id','topic_id','mood'),
...
...
...
('report_id','politician_id','topic_id','mood');


to calculate the mood.....
how are we going to do that?
and how to assign it to the correct topic_id? based ont he name

___________________________________________

NOTE:
to calculate the mood and insert them itno the database we need to run a php script

function ($politician_name, $topicname, $mood)
{
	//find proper topic_id related to the topic_name given
	$topic_id = mysql_fetch_assoc(mysql_query("SELECT topic_id FROM temachmaga_topic WHERE topic_name='$name_from_topic'"));
	
	//find proper politician_id related to the speaker
	$politician_id = mysql_fetch_assoc(mysql_query("SELECT id FROM temachmaga_politicians WHERE name='$politician_name'");

	//insert into db	
	mysql_query("INSERT INTO temachmaga_politician_topic (`politician_id` ,`topic_id` ,`mood`) VALUES ('$politician_id','$topic_id','$mood')");
}
*/

?>