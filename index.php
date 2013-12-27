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
                    include("php/purchasepal.php");
                    $pp = new PurchasePal();
                 
                    
                    if(isset($_POST["txn_id"])){ 
                        //IF COMING FROM PURCHASE
                        $pp->printDownload();

                    }else if(isset($_GET["expired"])){
                        //IF LINK EXPIRED
                        $pp->printExpired();

                    }else {
                        //IF COUNTRY VALID
                        if($pp->user->valid_country)
                            echo $pp->createForm();
                        else
                            echo $pp->invalidCountry();

                    }

                    
                ?> 

                  
                     <blockquote><a href="http://surfingstrange.com/booklet">Download Album Artwork</a></blockquote>
                    <blockquote>
                    <p>Click above to download all 11 songs as 320kbps MP3s!</p>
                    <p>After sending money through paypal, you will get an email containing the link to download the record. Paypal will also return you to the site after your purchase so you can download directly. </p>
                   
                    <hr />
                   
                    <p>Please contact <strong>info</strong> @ this website if you have any problems.</p>
                       
                    </blockquote>

            
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