<?php
class Copeac extends Network{
	private $cookie_jar = "./cookies.txt";

	//return false on failure
	public function getEarnings($startDate, $stopDate){
			//get earnings for date range from copeac.com
		$url = 'http://emt.copeac.com/forms/login.aspx';
		$fields = array(
		urlencode('__LASTFOCUS')=> '',
		urlencode('__EVENTTARGET')=>	'',
		urlencode('__EVENTARGUMENT')=>	'',
		urlencode('__VIEWSTATE')=>	
			urlencode('/wEPDwUKLTUzNTk1MDMyOGQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgIFC2Noa3JlbWVtYmVyBQlidG5TdWJtaXQ='),
		            'txtUserName'=>urlencode($this->username),
		            'txtPassword'=>urlencode($this->password),
						urlencode('btnSubmit.x')=>	urlencode("0"),
						urlencode('btnSubmit.y')=>urlencode("0")
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
		//curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
		
		//execute post
		$result = curl_exec($ch);
	
		
		//return 99;
		//execute post
		$result = curl_exec($ch);
		$totals = $this->get_string_between($result, "Revenue Today", '</td>');
	
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