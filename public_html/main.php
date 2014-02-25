                
                <form id="searchbox" action="searchPerson.php" method="POST">
                    <div id="reset_filters" onclick="location.href='index.php'">Reset Filters</div>
                    <input type="text" name="name" size="80" style="margin-left: 172px;">
                    <input type="submit" value="search me">
                </form>
                
                <?php
                if (isset($_SESSION['result']))
                {
                    if ($_SESSION['result'] != "")
                    {
                        if ($_SESSION['result'] == "notfound")
                        {
                            echo "No results were found.";
                            $sql = mysql_query("SELECT * FROM temachmaga_politicians");
                        }
                        else
                        {
                            $sql = mysql_query($_SESSION['result']);
                        }
                        $_SESSION['result']=""; //reset the search parameter
                    }
                    else
                    {
                        $sql = mysql_query("SELECT * FROM temachmaga_politicians");
                    }
                }
                else
                {
                    $sql = mysql_query("SELECT * FROM temachmaga_politicians");
                }
                ?> 
              <div class="arrows" id="arrowL"><img src="images/arrowL.png" width="29px" height="44px"></div>
              <div class="arrows" id="arrowR"><img src="images/arrowR.png" width="29px" height="44px"></div>
              <div id="outerlist">
                
                <div id="list">
                    <?php
                        if (isset($sql))
                        {
                            $results=0;
                            while ($rows = mysql_fetch_array($sql))
                            {
                                $results++;
                                echo mysql_error();
                                ?>
                                    
                                    <div id="list-<?php echo $rows['id']; ?>" class="item" style="opacity:1">
                                        <img src="<?php echo $rows['image']; ?>" width="170px" height="200px"/><br/>
                                        
                                        <div class="tab">
                                            <?php echo $rows['name']; ?><br/>
                                        </div>
                                        <?php /*
                                        <div class="tab">
                                            <b>Party: </b><br/><?php echo $rows['party']; ?><br/>
                                        </div>
                                        <div class="tab">
                                            <b>Representing: </b><br/><?php echo $rows['representing']; ?><br/>
                                        </div>
                                        */ ?>
                                    </div>
                                <?php
                            }
                        }
                    ?>   
                
                </div>
                
              </div>
              
              <?php echo "Displaying ".$results." entries."; ?>
            
                <script>                
                    $(document).on('click', '#arrowL', function(){
                        leftAmount--;
                        $('#list').animate({scrollLeft:816*(leftAmount.mod(<?php echo ceil($results/4); ?>))}, '500');
                    });
                    $(document).on('click', '#arrowR', function(){
                        leftAmount++;
                        $('#list').animate({scrollLeft:816*(leftAmount.mod(<?php echo ceil($results/4); ?>))}, '500');
                    });
                    $(document).on('mouseenter', '.arrows', function(){
                        var newSrc = "images/" + $(this).attr('id') + "H.png";
                        $('img', this).attr('src', newSrc ).animate({height:'132px'},{ queue: false, duration: 350 });
                        $(this).animate({marginTop:'146px'},{ queue: false, duration: 350 });
                        //$('.item').animate({opacity: 0.8},300);
                    });
                    $(document).on('mouseleave', '.arrows', function(){
                        var oldSrc = "images/" + $(this).attr('id') + ".png";
                        $('img', this).attr('src', oldSrc ).animate({height:'44px'},{ queue: false, duration: 350 });
                        $(this).animate({marginTop:'190px'},{ queue: false, duration: 350 });
                        //$('.item').animate({opacity: 0.5},300);
                    });
                </script>
            
            <div id="content">
            
                
            
            </div>