<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

	<style type="text/css">
		body {
			padding-top:50px;
		}
		fieldset {
			border: thin solid #ccc; 
			border-radius: 4px;
			padding: 20px;
			padding-left: 40px;
			background: #fbfbfb;
		}
		legend {
			color: #678;
		}
		.form-control {
			width: 95%;
		}
		label small {
			color: #678 !important;
		}
		span.req {
			color:maroon;
			font-size: 112%;
		}
	</style>

</head>
<body>

	<div class="container">
		<div class="row">

			<form action="" method="post" id="send_mail" role="form">
				<fieldset>
					<div class="form-group">
						<label for="to"><span class="req">* </span> To </label> 
						<input class="form-control" required type="text" name="to" id = "to"  onchange="email_validate(this.value);" />   
						<div class="status" id="status"></div>
					</div>
					<div class="form-group"> 	 
						<label for="subject"><span class="req">* </span> Subject: </label>
						<input class="form-control" type="text" name="subject" id = "subject" onkeyup = "Validate(this.value)" required /> 
						<div id="errsubject"></div>    
					</div>

					<div class="form-group">
						<label for="message"><span class="req">* </span> Message: </label> 
						<textarea rows="6" class="form-control" name="message" id = "message" onkeyup = "Validate_msg(this.value)" ></textarea>

						<div id="errmsg"></div>
					</div>



					<div class="form-group">
						<input class="btn btn-primary pull-right" id ="send_mail_btn" type="submit" name="submit_reg" value="Send">
					</div>


				</fieldset>
			</form><!-- ends register form -->
		</div>
	</div>
	<script type="text/javascript">
    	// validate email
    	function email_validate(email)
    	{
    		var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;

    		if(regMail.test(email) == false)
    		{
    			document.getElementById("status").innerHTML    = "<span class='warning'>Email address is not valid yet.</span>";
    			document.getElementById("status").style.color = "red";
    			$("#subject").val('');
    		}
    		else
    		{
    			document.getElementById("status").innerHTML = ""; 

    		}

    	}
function Validate(s)
    	{
    		reWhiteSpace = new RegExp(/^\s+$/);
    		if (reWhiteSpace.test(s)) {
          /*alert("Please Check Your Fields For Spaces");
          return false;*/
          document.getElementById("errsubject").innerHTML    = "<span class='warning'>Please Check Your Fields For Spaces</span>";
          document.getElementById("errsubject").style.color = "red";
          $("#to").val('');
      }
      else
      {
      	document.getElementById("errsubject").innerHTML = ""; 

      }
  }
  function Validate_msg(s)
  {
  	reWhiteSpace = new RegExp(/^\s+$/);
  	if (reWhiteSpace.test(s)) {
          /*alert("Please Check Your Fields For Spaces");
          return false;*/
          document.getElementById("errmsg").innerHTML    = "<span class='warning'>Please Check Your Fields For Spaces</span>";
          document.getElementById("errmsg").style.color = "red";
          $("#to").val('');
      }
      else
      {
      	document.getElementById("errmsg").innerHTML = ""; 

      }
  }
</script>
<script type="text/javascript">
	$("#send_mail").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
url: "backend/mail.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,
beforeSend: function() {
        // setting a timeout
        $("#send_mail_btn").val('Sending');
    },        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
	alert(data);
	window.location.href="compose_mail.php";

}
});
	}));

</script>
</body>
</html>