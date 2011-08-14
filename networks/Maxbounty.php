<?php
class Maxbounty extends Network{
	private $cookie_jar = "./cookies.txt";
	

	
	
	//return false on failure
	public function getEarnings($startDate, $stopDate){
			//get earnings for date range from maxbounty.com
		$url = 'http://www.maxbounty.com/main.cfm';
		$fields = array(
		            'e_mail'=>urlencode($this->username),
		            'password'=>urlencode($this->password),
		            'x'=>urlencode('0'),
		            'y'=>urlencode('0')
					);
		$fields_string = "";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
	
		//open connection
		$ch = curl_init();
		
		//prepare post request
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->cookie_jar); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_HEADER,true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		
		//execute post
		$result = curl_exec($ch);
		//error_log($result);
		
		
		//execute post
		$result = curl_exec($ch);
		$totals = $this->get_string_between($result, "Today's Earnings</td>", '</tr>');
		$total = $this->get_string_between($totals, '$','</a>');
		//close connection
		curl_close($ch);
		
		if(is_numeric($total)){
			return money_format("%i",$total);	
		} else {
			return false;		
		}
		
		
		
		
	}	
}
?>