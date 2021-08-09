<?php
//https://github.com/helixcrew/HaxorID-Grabber/
//https://www.helixsid.today
//Live API Version http://tools.helixs.tech/API/haxorid.php
header('Content-type: application/json');
function getpage($from, $page)
{
	$i = 1;
  //Set Limit
	if ($page >= 100) {
		$api['error'] = 'Max Page Is 100!!';
		echo json_encode($api);
	} else {
		while ($i <= $page) {
			$getpages = "$from?page=$i";
			$url = file_get_contents($getpages);
			$scrap = preg_match_all("/<a title='([a-z0-9]+([\.-][a-z0-9]+)*)(.+?)(?:\"|\')(?:.+?) target='_blank'/i", $url, $getdomain);
			$resultgrab = array_unique($getdomain[1]);
		    $result['status'] = 'success';
			$result["result_$i"] = array_filter($resultgrab);
			$i++;
		}
		
		if(isset($_GET['text'])) {
		    $i = 1;
		    $json = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	        $data = json_decode($json, true);
		   while ($i <= $page) {
                $results = $data["result_$i"];
		echo"".implode("\n",$results)."";
		        $i++;
		      }
			} else {
		echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
			}
	}
}
$from 		= htmlspecialchars($_GET['from']);
$page 		= htmlspecialchars($_GET['pages']);

//Thanks For 4DSec
if (!empty($from) && !empty($page)) {
	if ($from == 'archive') {
		$url = 'https://hax.or.id/archive';
		echo getpage($url, $page);
	} else if ($from == 'special') {
		$url = 'https://hax.or.id/archive/special';
		echo getpage($url, $page);
	} else if ($from == 'onhold') {
		$url = 'https://hax.or.id/archive/onhold';
		echo getpage($url, $page);
	}
} 
else if (empty($from)) {
  $result['status'] = 'Bad';
	$result['result'] = 'URL empty';
	echo json_encode($result);
}
