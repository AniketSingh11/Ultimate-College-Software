<?php

# Use the Curl extension to query Google and get back a page of results
$url = "http://localhost/christ/sms/billing.php?roll=10880-ANTO+SHEFFRIN++J++%28II+A+-+JERLIN+GNANAM+FERNANDO++P+%29&bid=1";
echo $url;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
echo $html = curl_exec($ch);
curl_close($ch);

# Create a DOM parser object
$dom = new DOMDocument();

# Parse the HTML from Google.
# The @ before the method call suppresses any warnings that
# loadHTML might throw because of invalid HTML in the page.
@$dom->loadHTML($html);

# Iterate over all the <a> tags
$n=0;
foreach($dom->getElementsByTagName('td') as $link) {
        # Show the <a href>
		$n++;
		if($link->nodeValue=="Total:")
        echo $dom->getElementsByTagName('td')->item($n)->nodeValue;
		
}


?>

