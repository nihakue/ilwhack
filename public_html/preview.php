<?php
    
    function filter_stuff($input)
    {
	//extract ,
	if (strrpos($input,","))
	{
		$input = substr($input,0,(strrpos($input,",")));
	}
	//extract and
	else if (strrpos($input,"and"))
	{
		$input = substr($input,0,(strrpos($input," and")));
	}
	
	//extract East
	if (strrpos($input,"East"))
	{
		$input = substr($input,0,(strrpos($input,"East")));
	}
	//extract West
	if (strrpos($input,"West"))
	{
		$input = substr($input,0,(strrpos($input,"West")));
	}
	//extract North
	if (strrpos($input,"North"))
	{
		$input = substr($input,0,(strrpos($input,"North")));
	}
	//extract South
	if (strrpos($input,"South"))
	{
		$input = substr($input,0,(strrpos($input,"South")));
	}
	//extract Central
	if (strrpos($input,"Central"))
	{
		$input = substr($input,0,(strrpos($input,"Central")));
	}
	
	//extract whitespace
	if (strrpos($input," "))
	{
		$input = substr($input,0,(strrpos($input," ")));
	}
	
	return $input;
    }
    
    function get_gss($input)
    {
    	$input = filter_stuff($input);
    
	if ($input=="Aberdeen") 		{return "S12000033";}
	else if ($input=="Aberdeenshire") 	{return "S12000034";}
	else if ($input=="Angus") 		{return "S12000041";}
	else if ($input=="Argyll") 		{return "S12000035";}
	else if ($input=="Ayr") 		{return "S12000028";}
	else if ($input=="Clackmannanshire") 	{return "S12000005";}
	else if ($input=="Clydebank") 		{return "S12000039";}
	else if ($input=="Clydesdale") 		{return "S12000029";}
	else if ($input=="Dumfriesshire") 	{return "S12000006";}
	else if ($input=="Dundee City") 	{return "S12000042";}
	else if ($input=="Dunfermline") 	{return "S12000015";}
	else if ($input=="Eastwood") 		{return "S12000011";}
	else if ($input=="Edinburgh") 		{return "S12000036";}
	else if ($input=="Ettrick") 		{return "S12000019";}
	else if ($input=="Falkirk") 		{return "S12000014";}
	else if ($input=="Galloway") 		{return "S12000006";}
	else if ($input=="Glasgow") 		{return "S12000046";}
	else if ($input=="Airdrie") 		{return "S12000044";}
	else if ($input=="Lothian")		{return "S12000010";}
	else if ($input=="Almond") 		{return "S12000040";}
	else if ($input=="Kilbride")		{return "S12000029";}
	else if ($input=="Carrick") 		{return "S12000028";}
	else if ($input=="Coatbridge") 		{return "S12000044";}
	else if ($input=="Cowdenbeath") 	{return "S12000015";}
	else if ($input=="Cumbernauld") 	{return "S12000044";}
	
	else if ($input=="Cunninghame") 	{return "S12000028";}
	else if ($input=="Dumbarton") 		{return "S12000039";}
	else if ($input=="Banffshire") 		{return "S12000034";}
	else if ($input=="Caithness") 		{return "S12000017";}

	else if ($input=="Greenock") 		{return "S12000018";}
	else if ($input=="Hamilton") 		{return "S12000029";}
	else if ($input=="Highlands") 		{return "S12000017";}
	else if ($input=="Kilmarnock") 		{return "S12000008";}
	else if ($input=="Kirkcaldy") 		{return "S12000015";}
	else if ($input=="Linlithgow") 		{return "S12000040";}
	else if ($input=="Mid") 		{return "S12000015";}
	else if ($input=="Midlothian") 		{return "S12000019";}
	else if ($input=="Moray") 		{return "S12000020";}
	else if ($input=="Motherwell") 		{return "S12000044";}
	else if ($input=="Paisley") 		{return "S12000038";}
	else if ($input=="Perthshire") 		{return "S12000024";}
	else if ($input=="Renfrewshire") 	{return "S12000038";}
	else if ($input=="Rutherglen") 		{return "S12000029";}
	else if ($input=="Skye") 		{return "S12000017";}
	else if ($input=="Stirling") 		{return "S12000030";}
	else if ($input=="Strathkelvin") 	{return "S12000045";}
	else if ($input=="Uddingston") 		{return "S12000029";}
	else {return "-1";}
    }
?>

<?php
include 'dbconnect.php';
$id = $_GET['np'];

if (is_int((int)$id))
{
	function get_politician_name($id)
	{
	    $result = mysql_fetch_assoc(mysql_query("SELECT name FROM temachmaga_politicians WHERE id='$id'"));
	    if ($result)
	    {
	        return $result['name'];
	    }
	    else
	    {
	        return "-1";
	    }
	}
	
	$name = get_politician_name($id);



    $person = mysql_fetch_assoc(mysql_query("SELECT * FROM temachmaga_politicians WHERE id='$id'"));
?>

<script>
$(function(){
var gssCode = "<?php echo get_gss($person['representing']); ?>";
var mapjson = "gssdata/" + gssCode + "_topo.json";

var width = 200,
    height = 300;

var projection = d3.geo.albers()
    .center([-0.34, 57.028])
    .rotate([4.4, 0])
    .parallels([50, 60])
    .scale(3760)
    .translate([width / 2, height / 2]);

var path = d3.geo.path()
    .projection(projection);

var svg = d3.select("#previewMap").append("svg")
    .attr("width", width)
    .attr("height", height);

d3.json(mapjson, function(error, councilArea) {
  svg.append("path")
      .datum(topojson.feature(councilArea, councilArea.objects[gssCode + "_geo"]))
      .attr("id", "council_area")
      .attr("d", path);
});
});
</script>

<?php
	//MONGO DB DATA
	$mspname = $person['name'];
	$mspspeech = $speeches->find(array("name" => $name));
	$mspmsp = $msps->find(array("name" => $name));
	$speechid=0;
	//$months = array("October"=>rand(0,10),"November"=>rand(0,10),"December"=>rand(0,10),"January"=>rand(0,10),"February"=>rand(0,10));
	//$months["October"];
	if ($mspspeech->count())
	{
		foreach($mspmsp as $personguy)
		{
			$msp_name = $personguy['name'];
			$msp_mood = (round(100*$personguy['overall_mood'])/100);
			$msp_awl = (round(100*$personguy['awl'])/100);
			$msp_ttn = $personguy['ttn'];
			$msp_ttv = $personguy['ttv'];
			$msp_month_happiness = $personguy['month_moods'];
			
			
		}
	}
	else
	{
		foreach($mspmsp as $personguy)
		{
			echo "No recent data found.";
			$msp_name = $mspname;
			$msp_mood = 5;
			$msp_awl = 0;
			$msp_ttn = array(0=>"No data found.");
			$msp_ttv = array(0=>"No data found.");
			$msp_month_happiness = array();
		}
	}






    //taking mood average
    $moodarray = mysql_query("SELECT mood FROM temachmaga_speech WHERE politician_name='$name'");
    $mood=0;
    $length = 0;
    while ($rows = mysql_fetch_array($moodarray))
    {
    	$length++;
    	$mood += $rows['mood'];
    }
    if ($length != 0) { $mood /= $length; } else {$mood = 5;}
    
    ?>    
        <div class='line_item'>
        	<div class="line_item_part">        
	         <div class="previewLeft" style="margin-left:15px">
	            <div class='line_img'>
	                <img src="<?php echo $person['image']; ?>" width="170px" height="200px"/><br/>
	            </div>

	 
		  </div>
		 <div class="previewRight" style="margin-left:35px">
	            <div class='line_info'>
	                <b>Name: </b><?php echo $person['name']; ?><br/>
	                <b>Party: </b><?php echo $person['party']; ?><br/>
	                <b>Representing: </b><?php echo $person['representing']; ?><br/>
	            </div>
	            
	            <script type="text/javascript">

			$(function() {
				<?php if (count($msp_month_happiness)<5)
				{
				?>
				var d1 = [["October", Math.floor((Math.random()*10)+5)], ["November", Math.floor((Math.random()*10)+5)], ["December", Math.floor((Math.random()*10)+5)], ["January", Math.floor((Math.random()*10)+5)], ["February", Math.floor((Math.random()*10)+5)]];
				<?php
				}
				else
				{
				
				?>

				var d1 = [["October", <?php echo $msp_month_happiness[0]; ?>], ["November", <?php echo $msp_month_happiness[1]; ?>], ["December", <?php echo $msp_month_happiness[2]; ?>], ["January", <?php echo $msp_month_happiness[3]; ?>], ["February", <?php echo $msp_month_happiness[4]; ?>]];
				<?php
				}
				?>
				
				$.plot("#placeholder", [ d1 ], {
			series: {
				lines: { show: true, fill: true }
			},
			xaxis: {
				mode: "categories",
				tickLength: 0
			}
		});

			});

	</script>
	            
	            <div class="demo-container">
			<div id="placeholder" class="demo-placeholder"></div>
		    </div>
	            
	            <script>
	            $(document).ready(function(){
	            	$('#meterbar').rotate(<?php echo ($msp_mood*18) ?>);
	            });
	            
	            </script>
		 </div>
		 
		 <div style="float:right;box-shadow:0px 0px 15px rgba(255, 255, 255, 0.32); height:200px; margin-right:20px; padding-top:40px;" >
	              <div id="moodMeter" style="width:155px;height:77px;background:url('images/meter.png');text-align:center;background-repeat:no-repeat">
	            	<img id="meterbar" src="images/meterbar.png" style="margin-top:55px;margin-left:0px" />
	            	<b>Overall Mood</b><br/>
	            	
	            	
	            	<?php 
	            	

	            	echo "<span style='font-size:30px;'>".$msp_mood . " / 10</span>";
	            	
	            	
	            	?>
	            	
	            	
	            	
	              </div>
	            </div>
		</div>
		
		<div class="line_image_bit">
			<div class="previewLeft" >
				<div id="previewMap">

				</div>
			</div>
			<div class="previewRight" style="min-height:300px">
				
					<div id="topnouns" style="float:left;margin-left:70px;margin-top:10px;"><span style='font-size:18px;'><center>Top 10 Nouns</center></span><hr><br/>
						<div class="innerLeft" style="float:left">
						
						<?php
						foreach($msp_ttn as $x)
						{
							echo $x[0]."<br/>";
						}
						?>
						
						</div>
						<div class="innerRight" style="float:right">
						<?php
						foreach($msp_ttn as $x)
						{
							echo $x[1]."<br/>";
						}
						?>
						</div>
					</div>
					<div id="topverbs" style="float:left;margin-left:100px;margin-top:10px"><span style='font-size:18px;'><center>Top 10 Verbs</center></span><hr><br/>
						<div class="innerLeft" style="float:left">
						<?php
						foreach($msp_ttv as $x)
						{
							echo $x[0]."<br/>";
						}
						?>
						</div>
						<div class="innerRight" style="float:right">
						<?php
						foreach($msp_ttv as $x)
						{
							echo $x[1]."<br/>";
						}
						?>
						</div>

					</div>			
					
			</div>
		</div>
		
        </div>    
    <?php

    
    	$mspspeech = $mspspeech->limit(5);

    	echo "<div class='line_speech' style='text-align:center; font-size: 30px;'>Recent Speeches</div>";
	foreach ($mspspeech as $documentthing) 
	{
		$speechid++;
	    //name
	    $msp_speech_name = $documentthing['name'];
	    $msp_speech_date =  $documentthing['date'];
	    
	    
	    //topic
	    $msp_speech_topic = $documentthing["topic"];
	    //mood
	    $mps_speech_mood = $documentthing["mood"];
	    //content
	    $msp_speech_content = $documentthing["speech"];
	    
	    
	    ?>
	    
	    	
	        <div class='line_speech'>
	        	<?php echo "#".$speechid."<br/>"; ?>
	        	<b>Speaker: </b><?php echo $msp_speech_name;?><br/>
	        	<b>Date: </b><?php echo $msp_speech_date;?><br/>
	        	<b>Topic: </b><?php echo $msp_speech_topic;?><br/>
	        	<b>Mood: </b><?php echo $mps_speech_mood;?><br/>
	        	<b>Content: </b><?php echo $msp_speech_content;?><br/>
	   
	        </div>
	    
	    
	    <?php
	}
    
    
    
}

echo "<script>
        $('.contentNP').fadeIn(300);
      </script>";
//echo "<div class='contentNP' style='display:none;text-align:center;'><p>HI MISTER " . $id . "</p></div>";
?>