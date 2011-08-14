<?php
class Cpaway extends Network{
	private $cookie_jar = "./cpawaycookies.txt";
	
	
	
	
	//return false on failure
	public function getEarnings($startDate, $stopDate){
			//get earnings for date range from cpaway.com
		$url = 'https://portal.cpaway.com/go/login';
		$fields = array(
		            'email'=>urlencode($this->username),
		            'password'=>urlencode($this->password),
		            'login'=>urlencode("Log-in")
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

		//logged in, got cookie
		//open connection
		//$ch = curl_init();
		$url = 'https://portal.cpaway.com/go/report_summary';
		//prepare post request
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->cookie_jar); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,true);
		
		//execute post
		$result = curl_exec($ch);
		$totals = $this->get_string_between($result, '<div class="td">Totals</div>', '<div style="clear:both;">');
		$total = $this->get_string_between($totals, '$','</div>');
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