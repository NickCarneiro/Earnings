
<!DOCTYPE html> 
<html>
 
  <head> 
    <title>Affiliate Network Earnings</title> 
   
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
	
	<link rel="stylesheet" href="earnings.css" type="text/css" />
	<script src="earnings.js"></script> 
  </head> 
 
  <body> 
<div id="header">
	<h1>Earnings</h1><br />
	<span>Affiliate Network Earnings</span>
</div>
  <div id="earnings_credentials">
	<div id="prompt_controls">
	<fieldset>
	<span id="name_error">Enter your credentials:</span><br />
	<label>Username: <br />
		<input id="earnings_username" type="text" /></label><br />
	<label>Password: <br />
		<input id="earnings_password" type="password" /></label><br />
		<label>
		 <input id="credentials_submit" type="submit" value="Log in"/><br />
 <br />
 </label>
	</fieldset>
	</div>
  </div>
  
<div id="earnings_container">

	<div id="earnings_box">
				<button id="refresh">Refresh</button>	<button id="logout_button" href="#">Logout</button>
				<ul id="earnings_list">
					<li>No earnings available</li>
					
				</ul>
			

	</div>

</div>

<div id="footer">
Created by <br /> <a href="http://twitter.com/nickc_dev">Nick Carneiro</a>
</div>
</body> 
 
</html> 