<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Selected Psalm</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <script>
            function ReadPsalm(){
                var sel=document.getElementById('pssel');
                var url=sel.options[sel.selectedIndex].value;
                window.location=url;
                }
        </script>
    </head>
    <body>
        <a href="index.php">Today's Psalm</a>
        <?php
            $var = explode('&',$_SERVER["QUERY_STRING"]);
            $num=str_replace("p=", "", $var[0]);
            $psalm = sprintf("./%s.txt", $num);
            // get all contents (pre-formatted html)
            $file = file_get_contents($psalm,true);
            if($file===FALSE){echo "can't open Psalm ".$num;}
            else
            {
               // echo all the lines back to the client.
               echo $file;
            }
        ?>
        <label>Read Psalm:</label>
        <select name="p" id="pssel" onchange="ReadPsalm();">
        <?php
            for($ps=1;$ps<151;$ps++){
                $tmp = sprintf("%d",$ps);
                if(0==strcmp($tmp,$num)) {printf("<option value=\"select.php?p=%d\" selected>%d</option>",$ps,$ps);}
                else {printf("<option value=\"select.php?p=%d\">%d</option>",$ps,$ps);}
            }
        ?>
        </select>
        <div class="footer">Psalm for today is from the World English Bible (copyright free.)</div>
    </body>
</html>
