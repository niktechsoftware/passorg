<?php function sms($number,$msg)
{  

$url="http://mysms.sms7.biz/rest/services/sendSMS/sendGroupSms?AUTH_KEY=4eaf1b2ae65013df3fe85988f23f8f&message=".urlencode($msg)."&senderId=PASYSM&routeId=1&mobileNos=".$number."&smsContentType=english";
	//$url="http://zapsms.co.in/vendorsms/pushsms.aspx?user=PASS&password=pass1212&msisdn=".$number."&sid=PASYSM&msg=".urlencode($msg)."&fl=0&gwid=2";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$output=curl_exec($ch);
	$rt=json_decode($output,true);
    //echo $rt['response'];
	$dat =  $rt['response'];
	curl_close($ch);
return $dat;
}

function mysmsHindi($number,$msg){
 $url = "http://mysms.sms7.biz/rest/services/sendSMS/sendGroupSms?AUTH_KEY=4eaf1b2ae65013df3fe85988f23f8f&message=".urlencode($msg)."&senderId=PASYSM&routeId=1&mobileNos=".$number."&smsContentType=Unicode";
 	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$output=curl_exec($ch);
	$rt=json_decode($output,true);
	$dat =  $rt['response'];
	curl_close($ch);
return $dat;;
}
function checkBalSms()
{ 
$url  = "http://mysms.sms7.biz/getBalance?userName=pass&password=Pass@123";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$output=curl_exec($ch);

	$rt=json_decode($output,true);

	$dat =  $rt[0]['routeBalance'];

curl_close($ch);
return $dat;
}




function getAge($dob) {
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dob), date_create($today));
	return $diff->format('%yYears, %mMonths, %dDays');
}

function highlightText($text, $keywords) {
	$color = "yellow";
	$background = "red";
	foreach($keywords as $keyword) {
		$highlightWord = "<strong style='background:".$background.";color:".$color."'>" . $keyword . "</strong>";
		$text = preg_replace ("/" . trim($keyword) . "/", $highlightWord, $text);
	}
	$keywords = array("Coding 4 Developers","Coding for developers");
	echo highlightText($text, $keywords);
	return $text;
}


