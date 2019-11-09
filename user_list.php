<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	
	<!-- for data table--->
	<link href="
	https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
	<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet" id="bootstrap-css">
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
<style type="text/css">

	#image_preview{
		text-align: center;
		display: none;
	}
	#file {
		color: red;
		padding: 5px;
		border: 5px solid #8BF1B0;
		background-color: #8BF1B0;
		margin-top: 10px;
		border-radius: 5px;
		box-shadow: 0 0 15px #626F7E;
		margin-left: 15%;
		width: 72%;
	}

	#success
	{
		color:green;
	}
	#invalid
	{
		color:red;
	}
	#line
	{
		margin-top: 274px;
	}
	#error
	{
		color:red;
	}
	#error_message
	{
		color:blue;
	}
.avatar {
  vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<button type="button" class="btn btn-primary pull-right" data-toggle="modal" onclick ="reset_modal();" data-target="#myModal">
				Add User
			</button>
		</div><br><br>
		<div class="col-md-12" id="table_tbody" >

		</div>
		<!-- The Modal -->
		<div class="modal" id="myModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="uploadimage" action="" method="post" id="fileForm" role="form">
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Modal Heading</h4>
							<button type="button" id ="close_modal" class="close" data-dismiss="modal">&times;</button>
						</div>

						<!-- Modal body -->
						<div class="modal-body">

							<input  type="hidden" name="u_id" id = "u_id" value="0"/> 
							<input  type="hidden" name="insertuser" id = "insertuser" value=""/> 
							<div class="form-group">   
								<label for="firstname"><span class="req">* </span> Name: </label>
								<input class="form-control" type="text" name="name" id = "name" required /> 
								<div id="errFirst"></div>    
							</div>
							<div class="form-group">
								<label for="email"><span class="req">* </span> Email Address: </label> 
								<input class="form-control" required type="text" name="email" id = "email_id"  onchange="email_validate(this.value);" />   
								<div class="status" id="status"></div>
							</div>

							<div class="form-group">
								<label for="phonenumber"><span class="req">* </span> Phone Number: </label>
								<input required type="text" name="phonenumber" id="phone" class="form-control phone" maxlength="28" onkeyup="validatephone(this);" placeholder="not used for marketing"/> 
							</div>
							<div class="form-group">
								<label for="address"><span class="req">* </span> Address: </label> 
								<input class="form-control" type="text" name="address" id = "address" placeholder="hyphen or single quote OK" required />  
								<div id="statusAdd"></div>
							</div>
							<div class="form-group">
								<label for="age"><span class="req">* </span>Age </label> 
								<input class="form-control" type="number" name="age" id = "age"  placeholder="Enter Age" value ="" required />  
							</div>
						<div class="form-group" id ="status_div">
								<label for="user_status">Status</label> 
										<input  type="radio" style ="margin-left:20px" name="user_status" id = "st_active" value ="1"  />Active  
										 <input  type="radio" style ="margin-left:20px" name="user_status" id = "st_inactive" value ="0"  />In-active
									</div>
									
										<div class="form-group">
											<label for="file"><span class="req">* </span> Profile Image: </label>
											<input type="file" name="file" id="file"  required/>
										</div>

										<div class="form-group">
											<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
										</div>
									
								</div>

								<!-- Modal footer -->
								<div class="modal-footer">
									<!-- <button type="button" class="btn btn-primary" onclick ="insertdata()" data-dismiss="modal">Submit</button> -->
									<input class="btn btn-success"  type="submit" name="submit_reg" value="Submit">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
			<script type="text/javascript">
		// Function to preview image after validation
		$(function() {
			$("#file").change(function() {
	$("#message").empty(); // To remove the previous error message
	var file = this.files[0];
	var imagefile = file.type;
	var match= ["image/jpeg","image/png","image/jpg"];
	if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
	{
		$('#previewing').attr('src','noimage.png');
		$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
		return false;
	}
	else
	{
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
	}
});
		});
		function imageIsLoaded(e) {
			$("#file").css("color","green");
			$('#image_preview').css("display", "block");
			$('#previewing').attr('src', e.target.result);
			$('#previewing').attr('width', '250px');
			$('#previewing').attr('height', '230px');
		};
	</script>
<script type="text/javascript">

	function validatephone(phone) 
	{
		var maintainplus = '';
		var numval = phone.value
		if ( numval.charAt(0)=='+' )
		{
			var maintainplus = '';
		}
		curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
		phone.value = maintainplus + curphonevar;
		var maintainplus = '';
		phone.focus;
	}
// validate email
function email_validate(email)
{
	var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;

	if(regMail.test(email) == false)
	{
		document.getElementById("status").innerHTML    = "<span class='warning'>Email address is not valid yet.</span>";
		document.getElementById("status").style.color = "red";
     $("#email_id").val('');
	}
	/*else
	{
		document.getElementById("status").innerHTML = "<span class='valid'>Thanks, you have entered a valid Email address!</span>"; 
		document.getElementById("status").style.color = "green";
	}*/
}

</script>
<script type="text/javascript">
 $("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
 $('#myModal').modal('hide');
 $.ajax({
url: "backend/user_function.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
	alert(data);
	
	$('#u_id').val(0);
	$('#name').val('');
	$('#email_id').val('');
	$('#phone').val('');
	$('#address').val('');
	$('#age').val('');
	$('#file').val('');
	user_list();

}
});
}));

</script>

<script type="text/javascript">
	$(document).ready(function() {
	 user_list(); 
 } );
	function user_list(){
		var datastraing= "fetch_detail";
		document.getElementById('table_tbody').innerHTML="";
		$.ajax({
			type : 'POST',
			url : 'backend/user_function.php',
			data : datastraing,
			dataType: "json",
			success : function(response) {
					 //alert(response);
					 var thtmal ="";
					 thtmal += ' <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">';
					 thtmal += ' <thead>';
					 thtmal += '<tr>';
					 thtmal += ' <th>Profile Image</th>';
					 thtmal += ' <th>Name</th>';
					 thtmal += ' <th>Email</th>';
					 thtmal += ' <th>Mobile</th>';
					 thtmal += ' <th>Status</th>';
					 thtmal +=' <th>Date</th>';
					 thtmal += ' <th>Edit</th>';
					 thtmal += ' <th>Delete</th>';

					 thtmal += '</tr>';
					 thtmal += '</thead>';
					 thtmal += ' <tbody > ';
					 $.each(response, function(i,item) {
						thtmal += '<tr>';
						thtmal += '<td> <img src="'+item.profile_path+'" alt="Avatar" class="avatar"> </td>';	
						thtmal += '<td>'+item.username+'</td>';
						thtmal += '<td>'+item.email_id+'</td>';
						thtmal += '<td>'+item.mobile+'</td>';
						if(item.status==1){
						 thtmal += '<td style ="color:green"><b>Active</b></td>';
					 }
					 else{
						thtmal += '<td style ="color:red"><b>Inactive</b></td>';
					}
					thtmal += '<td>'+item.created_date+'</td>';
					thtmal += '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick ="update_user('+item.user_id+');" >Update</button></td>';
					thtmal += '<td><button type="button" class="btn btn-primary" onclick ="delete_user('+item.user_id+');" >Delete</button></td>';
					thtmal += '</tr>';
				});
					 thtmal += ' </tbody>';
					 thtmal += ' </table>';
					 document.getElementById('table_tbody').innerHTML=thtmal;
						// $('#table_tbody').append(thtmal);
						$('#example').DataTable();

					}
				});
	}	
</script>
<script type="text/javascript">
	function update_user(u_id){
	 $('#u_id').val(u_id);
	 var datastraing= "u_id="+u_id+"&fetch_user";
	 $.ajax({
		type : 'POST',
		url : 'backend/user_function.php',
		data : datastraing,
		dataType: "json",
		success : function(response) {
			$('#u_id').val(response[0].user_id);
			$('#name').val(response[0].username);
			$('#email_id').val(response[0].email_id);
			$('#phone').val(response[0].mobile);
			$('#address').val(response[0].address);
			$('#age').val(response[0].age);
			$('#previewing').attr('src',response[0].profile_path);
			$('#image_preview').css("display", "block");
      $('#status_div').css("display", "block");
			$("#file").removeAttr("required");
			if(response[0].status==1){
						 document.getElementById("st_active").checked = true;
					}else{
						 document.getElementById("st_inactive").checked = true;
					 }

				 }
			 });
 }
 function delete_user(u_id){
	if(confirm("Are you sure to delete this record"))
	{
		var datastraing= "u_id="+u_id+"&delete_user";
		$.ajax({
			type : 'POST',
			url : 'backend/user_function.php',
			data : datastraing,
			success : function(response) {
			 $('#u_id').val(0);
			 alert(response);
			 user_list();
		 }
	 });
	}
}
function reset_modal(){
 $('#u_id').val(0);
 $('#name').val('');
 $('#email_id').val('');
 $('#phone').val('');
 $('#address').val('');
 $('#age').val('');
 $('#file').val('');
 $('#image_preview').css("display", "none");
 $('#status_div').css("display", "none");
}
</script>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src=" https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src=" https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
</body>
</html>