<?php
   $num = date('z')+1;
   if($num>300) {$num -= 300;}
   if($num>150) {$num -= 150;}
   header("Content-Type: application/xml; charset=UTF-8");
   print("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n" );
   print("<rss version=\"2.0\" xmlns:dc=\"http://dublincore.org/documents/dcmi-namespace/\" >\n");
   print("  <channel>\n");
   printf("    <title>Psalm for today (Psalm %d)</title>\n",$num);
   print("    <link>http://psalmaday.azurewebsites.net</link>\n");
   printf("    <description>Psalm %d</description>\n",$num);
   print("    <language>en-us</language>\n");
   print("    <pubDate>" . date("D, d M Y H:i:s 0") . "</pubDate>\n");
   print("    <lastBuildDate>" . date("D, d M Y H:i:s 0") . "</lastBuildDate>\n");
   print("    <docs>http://cyber.law.harvard.edu/rss/rss.html</docs>\n");
   print("    <generator>http://psalmaday.azurewebsites.net Feed Engine</generator>\n");
   print("    <managingEditor>potter.dave.c@gmail.com</managingEditor>\n");
   print("    <webMaster>potter.dave.c@gmail.com</webMaster>\n");
   // get local file with adjusted day number. 
   $psalm = sprintf("./%s.txt", $num);
   // get all contents (pre-formatted html)
   $file = file_get_contents($psalm,true);
   $convert = explode("\n", $file);
   for ($i=0; $i<count($convert); $i++)
   {
      $pos = strpos($convert[$i],"<div class=\"number\">");
      if($pos === false)
         continue;
      $str = $convert[$i];
      $str = substr($str,20);
      $pos = strpos($str, "</div><div class=\"verse\"> ");
      $verse = substr($str,0,$pos);
      $str = substr($str,$pos);
      $str = str_replace("</div><div class=\"verse\"> ","",$str);
      $str = str_replace("</div>","",$str);
      print("    <item>\n");
      printf("      <title>Verse %s</title>\n", $verse);
      printf("      <link>http://psalmaday.azurewebsites.net/select.php?p=%d#%s</link>\n",$num,$verse);
      printf("      <description>%s</description>\n",$str);
      print("       <pubDate>" . date("D, d M Y H:i:s 0") . "</pubDate>\n");
      print("       <dc:created>" . date("D, d M Y H:i:s 0") . "</dc:created>\n");
      printf("      <guid>http://psalmaday.azurewebsites.net/select.php?p=%d#%s</guid>\n",$num,$verse);
      print("    </item>\n");
   }
   print("  </channel>\n");
   print("</rss>\n")
   //echo $file;
?>
