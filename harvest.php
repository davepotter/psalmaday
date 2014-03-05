<?php
    if(isset($_SERVER["QUERY_STRING"]))
    {
        die("harvest.php can't run in browser");
    }
    for($num=1;$num<151;$num++)
    {
        $opts = array(
          'http'=>array(
             'method'=>"GET",
             'header'=>"Accept-language: en\r\n"
             )
        );        
        //$url = sprintf('http://bibledatabase.net/html/kjv/psalms_%d.html', $num); // King James
        $url = sprintf('http://webnet77.com/bibles/web/19_%03d.htm', $num);         // World English Bible
        $context = stream_context_create($opts);
        // Open the file using the HTTP headers set above
        $file = file_get_contents($url, false, $context);
        $convert = explode("\n", $file);
        $blockseen = 0;
        $f = fopen("$num.txt","w+");
        fprintf($f,"<h3>Psalm %d</h3>\n",$num);
        fprintf($f,"<div class=\"container\">\n");
        for ($i=0; $i<count($convert); $i++)
        {
            if(preg_match("/blockquote/", $convert[$i]))
            {
                $blockseen = 1;
            }
            if($blockseen)
            {
                if(preg_match("/\d+:\d+/", $convert[$i]))
                {
                    $nochapter = str_replace("$num:", "", $convert[$i]);
                    $verse = str_replace("<br>", " ",$nochapter);
                    $verse = str_replace("<<", "[", $verse);
                    $verse = str_replace(">>", "]", $verse);
                    $verse = trim($verse);
                    preg_match("/^\d+/", $verse, $versno);
                    $verse = preg_replace("/^\d+/", "", $verse);
                    fprintf($f,"<div class=\"row\">\n");
                    fprintf($f,'<div class="number">%s</div><div class="verse">%s</div>%s',$versno[0],$verse,"\n");
                    fprintf($f,"</div>\n");
                }
            }
        }
        fprintf($f,"</div>\n");
        fflush($f);
        fclose($f);
        echo "$url\n";
        sleep(2); // be nice to bibledatabase.net
     }
     echo "Done";

?>
