<?php

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
			$replacementstring .= "filter:  progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='".$firstcolour."', endColorstr='".$secondcolour."');\r\n";
  			$replacementstring .= "-ms-filter: 'progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='".$firstcolour."', endColorstr='".$secondcolour."')';\r\n";
            $replacementstring .= "zoom:1;\r\n";
	
	
			$file = str_replace($fullstring,$replacementstring, $file);
			$state = 0;
			break;
			
			
		}
	}
}

echo $file;

?>
