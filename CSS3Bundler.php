<?php
header('Content-type: text/css');
$days_to_cache = 10;
header('Expires: '.gmdate('D, d M Y H:i:s',time() + (60 * 60 * 24 * $days_to_cache)).' GMT');

	$file = file_get_contents('exampleCSS.css');

while(strpos($file, "@CSS3_GRADIENT") != false)
{	
	$rule = "";
	$firstcolour = "";
	$secondcolour = "";
	$fullstring = "";
	
	$startpos = strpos($file, "@CSS3_GRADIENT");
	$currentpos = $startpos;
	
	
	$replacementstring = "";
		
	$state = 0;
	

	while(1)
	{
		$currentpos = $currentpos + 1;
		
		if($state == 0)
		{
			if($file[$currentpos]  == "(")
			{
				$state=1;
				
			}
			
		
			continue;
		}	
		
		if($state == 1)
		{
		
			if($file[$currentpos]  == ";")
			{
				$state=2;
				
			}
			else
			{
				$rule .= $file[$currentpos];
			}
			
			continue;
		}
		
		if($state == 2)
		{
			if($file[$currentpos]  == ";")
			{
				$state=3;
			}
			else
			{
				$firstcolour .= $file[$currentpos];
			}
			
			continue;
		}

		if($state == 3)
		{
		
	
		
			if($file[$currentpos]  == ")")
			{
				$state=4;
			}
			else
			{
				$secondcolour .= $file[$currentpos];
			}
			
			continue;
		}
		
		if($state == 4)
		{
			
			$fullstring = substr($file,$startpos, $currentpos - $startpos + 1);
		
			$replacementstring .= $rule.": -webkit-gradient(linear, left top, left bottom, from(".$firstcolour."), to(".$secondcolour."));\r\n";
			$replacementstring .= $rule.": -moz-linear-gradient(top,".$firstcolour.",".$secondcolour.");\r\n";
			$replacementstring .= $rule.": -o-linear-gradient(".$firstcolour.", ".$secondcolour.");\r\n";
		
	
			$file = str_replace($fullstring,$replacementstring, $file);
			$state = 0;
			break;
			
			
		}
	}
}

echo $file;

?>
