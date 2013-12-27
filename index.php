<!DOCTYPE HTML>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
    <title>Swearin' - Surfing Strange</title>

<meta property="og:url" content="http://www.surfingstrange.com" />
<meta property="og:image:type" content="image/jpeg" /> 
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="400" />
<meta property="og:image" content="http://www.surfingstrange.com/img/swearin-surfing-strange-400x400.png" />
<meta property="og:description" content="Download Swearin' - Surfing Strange for $7!" />
    <link rel="stylesheet" href="css/normalize.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
    <!--[if IE]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>



    <div class="menu" >
        <div class="container clearfix"  id="nav">

            <div class="grid_12">
                <ul class="navigation">
                    <li data-slide="1">Home</li>
                    <li data-slide="2">Media</li>
                    <li data-slide="3">Lyrics</li>
                    <li data-slide="4">Credits</li>
                </ul>
            </div>

        </div>
    </div>


    <div class="slide" id="slide1" data-slide="1" >
        <div class="container clearfix">

            <div id="logo" class="grid_12">
                <img src="img/swearin-surfing-strange.png" />
            </div>
            <div class="grid_3"></div>
            <div class="grid_6">
                <?
                    $today = time();
                    $event = mktime(0,0,0,11,4,2013);
                    $countdown = round(($event - $today)/86400);
      
                    if (isset($_SERVER['HTTP_CLIENT_IP'])) 
                        $real_ip_adress=$_SERVER['HTTP_CLIENT_IP']; 
                    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
                        $real_ip_adress=$_SERVER['HTTP_X_FORWARDED_FOR'];
                    else 
                        $real_ip_adress=$_SERVER['REMOTE_ADDR'];
 
                    $cip=$real_ip_adress;
                    $in_NA = false;
                    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$cip));   
                    if($ip_data && $ip_data->geoplugin_countryName != null){

                        if($ip_data->geoplugin_countryCode=="US" || $ip_data->geoplugin_countryCode =="CA" || $ip_data->geoplugin_countryCode == "MX" || $_GET["override"]=='1')
                            $in_NA = true;
                    }
                    


                    if($_POST["txn_id"]){ ?>
                  
                        <? if($countdown<=0) { ?>
                          <p>
                            <a href="http://www.surfingstrange.com/get/<?=$_POST["txn_id"]?>" class="paypal-button">DOWNLOAD THE RECORD</a><br /><br /><em>Good for 24 hours.</em>
                            </p>
                        <? }else{ ?>
                            <p>
                            <h1>Thanks!</h1> Check your email on Monday, November 4th for your link!
                            </p>
                        <? } ?>
                    </p>

                <? } else if($_GET["expired"]) { ?>
                    <h1>Expired</h1>
                    <p>Your download expired on <?=date('l dS \o\f F Y h:i:s A', $_GET["expired"])?></p>
                <? }else{ ?>
                    
                     <? if($in_NA){ ?>
 
                            <form method="post" action="https://www.paypal.com/cgi-bin/webscr" target="_top">
                                <input type="hidden" name="button" value="cart">
                                <input type="hidden" name="item_name" value="Swearin' - Surfing Strange 320 MP3">
                                <input type="hidden" name="amount" value="7">
                                <input type="hidden" name="shipping" value="0">
                                <input type="hidden" name="tax" value="0">
                                <input type="hidden" name="notify_url" value="http://www.surfingstrange.com/paypal/">
                                <input type="hidden" name="return" value="http://www.surfingstrange.com/">
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="add" value="true">
                                <input type="hidden" name="business" value="yourpaljeff@gmail.com">
                                <input type="hidden" name="env" value="www">
                                <button type="submit" class="paypal-button">BUY FOR $7</button>
                            </form>
                             <p><em>Downloads are restricted to North America only. Your files are available for 24 hours after your first download.</em></p>
                       
               
                     <? }else{ ?>

                    <blockquote><em>Download not available in your country. Please download from iTunes or visit <a href="http://shop.wichita-recordings.com/DigitalProduct.aspx?rid=682&fid=12&brid=5" target="_blank">Wichita</a> to purchase.</em>
                        <hr />

                    Please email info@surfingstrange.com with your IP : <?=$cip?>, if this is an error.</blockquote>
                <? } ?> 

                        

                        
               
                     <blockquote><a href="http://surfingstrange.com/booklet">Download Album Artwork</a></blockquote>
                    <blockquote>
                    <p>Click above to download all 11 songs as 320kbps MP3s!</p>
                    <p>After sending money through paypal, you will get an email containing the link to download the record. Paypal will also return you to the site after your purchase so you can download directly. </p>
                   
                    <hr />
                   
                    <p>Please contact <strong>info</strong> @ this website if you have any problems.</p>
                       
                    </blockquote>

                 <? }  ?>   
            </div>
        </div>
    </div>



    <div class="slide" id="slide2" data-slide="2" data-stellar-background-ratio="0.5">
        <div class="container clearfix">
            <div id="video" class="grid_7">
                <h3>Videos</h3>
                <hr />
                <iframe width="420" height="300" src="//www.youtube.com/embed/dmpOntxlbcY?showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="grid_5 omega">
                <h3>Press</h3>
                <hr />
                <table>
                <?
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://docs.google.com/spreadsheet/pub?key=0AivIixM-fxLJdDFmdGY1aGduQ2M3RG5XSXB5amFUV0E&single=true&gid=0&output=txt");
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $file = curl_exec($ch);
                    curl_close($ch);

     

                    $data_arr = explode("\n",$file);
                      $row = 1;
                    foreach($data_arr AS $d)
                    {       
                              $data = explode("\t",$d);

                              $stars = "";
                              if($data[3])
                                $stars = '<span class="stars"><span style="width:'.(65*($data[3]/100)).'px"></span></span>';
                                
                             $type = "";
                              if($data[4])
                                $type = '<span class="type">'.$data[4].'</span>';

                              $row++;
                              if($data[2])
                                echo '<tr><td><span class="type">'.$data[0].'</span></td><td><a href="'.$data[2].'" target="_blank">'.$data[1]." ".$type.'</a> '.$stars.' </td></tr>'."\n";
                              else
                                echo '<tr><td>'.$data[0].'</td><td>'.$data[1].' '.$stars.' </td></tr>'."\n";
                              
                             
                          
                      }
                 ?>  
                </table>
            </div>
        </div>
    </div>



    <div class="slide" id="slide3" data-slide="3" data-stellar-background-ratio="0.5">
        <div class="container clearfix">
            <div id="content" class="grid_12">
                <img src="img/lyrics.png" />
            </div>
        </div>
    </div>



    <div class="slide" id="slide4" data-slide="4" data-stellar-background-ratio="0.5">
        <div class="container clearfix">
            <div id="content" class="grid_12">
                <img src="img/credits.png" />
            </div>
        </div>
    </div>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.stellar.min.js"></script>
    <script type="text/javascript" src="js/waypoints.min.js"></script>
    <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/jquery.fitvids.js"></script> 

<script>
    $(function(){
        $("#video").fitVids();
        $('.slide').css({'min-height':($(window).height())+'px'});
    });
</script>
</body>
</html>