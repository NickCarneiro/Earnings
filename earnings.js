var earnings_state = {
	networks: []
}; //global contains state information for javascript app


function showEarnings(){
	$("#earnings_credentials").hide();
	$("#earnings_container").show();
	getEarnings();
	
}

//get earnings data from server and store in state variable
function getEarnings(){
	$("#earnings_list").empty();
	$("#earnings_list").append('<li>Retrieving earnings data.</li>');
	$("#earnings_list").append('<li><img src="spinner.gif" alt="spinner"></li>');
	$.post("earnings.php", {
		"getEarnings": true,
		"startDate": new Date().getTime(),
		"stopDate": new Date().getTime()
		},
		function(data){

			var networks = JSON.parse(data);
			console.log("networks.length: "+networks.length);
			if(networks.length > 0){
				earnings_state.networks = networks;
				delete networks;
				//calculate total
				var total = 0;
				for(var i = 0; i < earnings_state.networks.length; i++){
					var earnings = parseFloat(earnings_state.networks[i].earnings);
					if(earnings != NaN){
						total += earnings;
					}
					
				}
				earnings_state.networks.push({"network_name":"Total","earnings":total});
				renderEarnings();
				
			} else {
				$("#earnings_list").empty();
				$("#earnings_list").append("<li>Error retrieving earnings.</li>");	
				
			}
			
		});
			
}

//take data from state variable, put in DOM
function renderEarnings(){
	console.log("earnings_state.networks.length: " + earnings_state.networks.length);
	if(earnings_state.networks.length < 1){
		//nothing to render		
		return;	
	}
	$("#earnings_list").empty();
	console.log("len"+earnings_state.networks.length);
	for(var i=0; i < earnings_state.networks.length; i++){
		console.log("rendering "+ earnings_state.networks[i].network_name)
		if(earnings_state.networks[i].error){
			$("#earnings_list").append("<li>"+earnings_state.networks[i].network_name + ": "+earnings_state.networks[i].error+"</li>");		
		} else {
			$("#earnings_list").append("<li>"+earnings_state.networks[i].network_name + ": $"+earnings_state.networks[i].earnings+"</li>");	
		}
	}
}

$(function(){
$("#earnings_credentials").show();
$("#earnings_container").hide();

//check if logged in
$.post("earnings.php", {
		"loggedIn": true
		},
		function(data){
			var response = JSON.parse(data);
			if(response.loggedIn == "true"){
				//skip login screen if already logged in
				
				showEarnings();
							
			}
		});

function submitCredentials(){
	$.post("earnings.php", {
		"username": $("#earnings_username").val(),
		"password": $("#earnings_password").val() 
		},
		function(data){
			var response = JSON.parse(data);
			if(response.message){
				$("#name_error").empty();
				showEarnings();		
			} else if(response.error) {
				//login failed
				console.log(response.error);
				$("#name_error").text(response.error);
				$("#name_error").css("color", "red");
				
			} else {
				$("#name_error").text("Something went wrong on the server.");
				$("#name_error").css("color", "red");
			}
		}
	);
}

$("#credentials_submit").click(submitCredentials);	
$("#earnings_password").keypress(function(event){
	if(event.which == 13){
		submitCredentials();	
	}
});
	
	$("#logout_button").click(function(){
		$.post("earnings.php", {
		"logOut": true
		},
		function(data){
			$("#earnings_username").val("");
			$("#earnings_password").val("");
			$("#earnings_credentials").show();
			$("#earnings_container").hide();
		}
	);
		
	});
	
	$("#refresh").click(function(){
		
		getEarnings();
				
		
		
	});
	
});