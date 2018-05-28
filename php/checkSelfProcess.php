<?php
	if (php_sapi_name() === 'cli')
	{
		function checkSelfProcess()
	    {
	    	
	    	$count = 0;
	    	$namePathInfo = pathinfo($_SERVER['PHP_SELF']);
	    	$nameFileExtension = $namePathInfo['extension'];
	    	$nameFile = $namePathInfo['filename'];

	    	unset($namePathInfo);

	        exec("ps aux | grep " . $nameFile . " | awk '{print \$12\" \"\$13}'", $tmpProcessList);

	        foreach ($tmpProcessList as $k => $v)
	        {
	            preg_match_all('/' . $nameFile . '\.' . $nameFileExtension . '/', $v, $matches);
	            if(empty($matches[0]) === false)
	            {
	                $count++;
	            }
	            unset($matches);
	        }
	        return $count;
	    }

		var_dump(checkSelfProcess());exit;
	}
?>