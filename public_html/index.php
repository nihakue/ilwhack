<?php
    session_start();
    
?>

<html>
<head>
    <title>Matemachmaga ILW Smart-Data-Hack</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type='text/javascript' src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type='text/javascript' src="jQueryRotate.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://d3js.org/topojson.v1.min.js"></script>
    <script language="javascript" type="text/javascript" src="plugin/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="plugin/jquery.flot.categories.js"></script>
    <script>
        Number.prototype.mod = function(n) {
            return ((this%n)+n)%n;
        }
        
        var leftAmount = 0;
        //Hover effect on little images
        $(document).on('mouseenter','#outerlist',function(){
            $('.item').stop().animate({opacity: 0.5},300);
        })
        $(document).on('mouseleave','#outerlist',function(){
            $('.item').stop().animate({opacity: 1},100);
        })
        
        $(document).on('mouseenter','.item',function(){
            $(this).stop().animate({opacity: 1},300);
        })
        $(document).on('mouseleave','.item',function(){
            $(this).stop().animate({opacity: 0.5},100);
        })
        var pageScroll = function() {
                $('body,html').animate({scrollTop: 780}, 400);
        }
        
        //Defining previews
        var switchNP = function(id){
        
            document.location.hash = id;
            
            if (id == "team"){
                $("#mainContent").load("team.php").fadeIn(300);
                return false;
            }
            if (id == "main"){
                $("#mainContent").load("main.php").fadeIn(300);
                return false;
            }
    
            $("#content").css("min-height","840px", pageScroll()).load("preview.php?np="+id);
        
        }
        
        $(document).on('click','.item', function(){
                switchNP(this.id.replace('list-', ''));
                //switchTab(this.id.replace('list-', ''));
        });
        $(document).on('click','#btTeam', function(){
                document.location.hash = "team";
                $('#mainContent').fadeOut(200,function(){
                        $("#mainContent").load("team.php", function(){
                            $("#mainContent").fadeIn(200);
                        });
                });
        });
        $(document).ready(function() {
            var hash = window.location.hash.replace('#', '');
            var intTest = /^\d+$/;
            if (intTest.test(hash)){
                switchNP(hash);
                $('#mainContent').fadeIn(300);
            } 
            if (hash == 'team'){
                switchNP(hash);
            }
            if (hash == 'main'){
                switchNP(hash);
                $('#list').css("height", "430px");
            }
            if (hash == ''){
                $('#mainContent').fadeIn(300);
                $('#list').css("height", "310px");
            }
        });
    
    //precaching images
function preloadImage(url)
{
    var img=new Image();
    img.src=url;
}
var images = new Array( "images/arrowL.png",
			"images/arrowR.png",
			"images/meter.png",
			"images/meterbar.png",
			"images/arrowLH.png",
			"images/arrowRH.png"
			);

for (var i = 0;i<(images.length);i++){
	preloadImage(images[i]);
}
$(window).load(function(){		
	preloadImage(url);
});
    </script>
</head>
<body>
    <?php
        include 'dbconnect.php';
    ?>
    <div class="splitter">
            <div class="title">
                <img src="logo.png"/>
            </div>
    </div>
    <div id="wrapper">
    
        <div class="stylish"></div>
        <div id="menu">
            <div class="leftcorner"></div>
                <div id="btMain" class="button" onclick="location.href='index.php'">Main</div>
                <div id="btTeam" class="button">Team</div>
            <div class="rightcorner"></div>
        </div>
    
        <div id="banner"></div>
    
        <div id="header">
            <div id="userbar">
                <div id="inner_userbar">
                    <?php
                        //put useful data here
                        //retrieve variables
                        //run queries and enter results in table below
                        $membercount = mysql_query("SELECT COUNT(*) FROM temachmaga_politicians");
                        $membercount = mysql_fetch_assoc($membercount);
                        
                        $speachcount = mysql_query("SELECT COUNT(*) FROM temachmaga_speech");
                        $speachcount = mysql_fetch_assoc($speachcount);
                        
                        
                        $moodcount = mysql_query("SELECT COUNT(*) FROM temachmaga_speech");
                        $moodcount = mysql_fetch_assoc($moodcount);
                        
                        $visits = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_visits"));
                        $visits = $sql['visits'];
                        
                        $regions_array = (mysql_query("SELECT * FROM temachmaga_politicians GROUP BY representing "));
                        $region_count=0;

                        
                  
                        
                        while ($rows = mysql_fetch_array($regions_array))
                        {
                        	$regions_count++;
                        }
                        
                        
                    ?>
                        <table>
                            <tr>
                                <td>
                                   Please note: MoodSP is a prototype app developed for the 2014 Edinburgh ILW Hackathon. It uses a partially complete dataset, and parsing/analysis may not be perfect. As such, remember to take our conclusions with a grain of salt.
                                </td>
                            </tr>
                        </table>
                    <!--<form id="login" action="#" method="POST">
                        <table>
                            <tr>
                                <td colspan="2"><center><b>Login</b></center></td>
                            </tr>
                            <tr>
                                <td>Username: </td>
                                <td><input type="text" name="name" size="20"></td>
                            </tr>
                            <tr>
                                <td>Password: </td>
                                <td><input type="password" name="name" size="20"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><center><input type="submit" value="Confirm" style="width: 235px;"></center></td>
                            </tr>
                        </table>
                    </form>
                    -->
                </div>
            </div>
        </div>
        
        
        
        <div id="container">
            <div id="mainContent" style="display:none">
                <?php include("main.php"); ?>
            </div>  
        </div>
        
        <div id="footer">
            <center>&copy;TeMaChMaGa - All Rights Reserved</center>
        </div>
    </div>
</body>
</html>

<?php
    mysql_close();
?>