<?php

$raw = file ("./team.raw");
$myfile = fopen("teams.json", "w");

$parent = false;
$current = false;
$grp = false;
$list = array();
$mn = 1;

$blank = array(
  "groups" => array(),
  "ptitle" => "",
  "stitle" => "",
  "comment" => "",
  "image" => "",
  "checked" => "",
  "link" => ""
  );

$current = $blank;
$cards = array();

foreach ($raw as $k => $line)
    {
    if (preg_match("/^Title[:][\s]*(.+)[\s]*$/", $line, $m))
      {$current["stitle"] = trim($m[1]);}
    else if (preg_match("/^Role[:][\s]*(.+)[\s]*$/", $line, $m))
      {$current["groups"][]= trim($m[1]);}
    else if (preg_match("/^Biography[:][\s]*(.+)[\s]*$/", $line, $m))
      {$current["comment"]= trim($m[1]);}
    else if (preg_match("/^Personal[ ]webpage[:][\s]*(.+)[\s]*$/", $line, $m))
      {$current["link"]= trim($m[1]);}
    else if (!trim($line))
      {$cards[] = $current;
	$current = $blank;}
    else 
      {$current["ptitle"] = trim($line);}
    }

$json = json_encode ($cards);
fwrite($myfile, $json);
fclose($myfile);
//echo $json;
//prg(0, $cards);
exit;


//////////////////////////

function addLinks($matches) {
	if (count($matches) > 1)
		{echo "## ADDLINKS A ##\n";prg(0, $matches);
		 $out = "<a href='$matches[2]'>$matches[1]</a>";}
	else
		{echo "## ADDLINKS B ##\n";prg(0, $matches);
			$out = "<a href='$matches[0]'>$matches[0]</a>";}
  return($out);
}
 
function prg($exit=false, $alt=false, $noecho=false)
	{
	if ($alt === false) {$out = $GLOBALS;}
	else {$out = $alt;}
	
	ob_start();
	//echo "<pre class=\"wrap\">";
	if (is_object($out))
		{var_dump($out);}
	else
		{print_r ($out);}
	echo "\n";//</pre>";
	$out = ob_get_contents();
	ob_end_clean(); // Don't send output to client
  
	if (!$noecho) {echo $out;}
		
	if ($exit) {exit;}
	else {return ($out);}
	}
//*/
?>
