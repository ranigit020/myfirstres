<!DOCTYPE html>
<html>
<head>
	<title>Dynamic Table</title>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <style type="text/css">

td {
	padding: 25px;
 border: 1px solid lightgrey; 
}
	</style>
</head>
<body>
<label>Rows: <input type="number" name="rows" id="rows" onkeyup ="reset(0);"/></label><br />
<label>Columns: <input type="number" name="cols" id="cols" onkeyup ="reset(0);"/></label><br/>
<input name="generate" type="button" value="Create Table!" onclick='createTable();'/>
<input name="reset" type="button" value="Reset!" onclick='reset(1);'/><br/><br/>
<div id="wrapper"></div>
<br/><br/>
 <div  id ="text_section" style='display:none'>
 <label> Select Rows: <select  id="selected_row"></select></label>
<label>Select Columns: <select  id="selected_col"></select></label>
<br />
<label>Text: <input type="text" name="cell_text" id="cell_text" value =""/></label>
<input name="set_text" type="button" value="Set Text" onclick='set_text();'/>
</div>
<script type="text/javascript">
	
function createTable()
{
	var num_rows = document.getElementById('rows').value;
	var num_cols = document.getElementById('cols').value;
	if (num_rows == "" || num_cols == "") {
		alert("Please enter some numeric value in Row and Column");
	}
	else if (num_rows <=0 || num_cols <=0) {
		alert("Please enter greater than 0 in Row and Column");
	} 
	 else {
	
	var tbody = '';
   
		var theader = '<div><table border="1" id ="mytable">\n';
			for(var u=1; u<=num_rows; u++){
			  tbody += '<tr class ="tablerow">';
				for( var j=1; j<=num_cols; j++)
				{
				tbody += '<td class ="tablecol"  id ="cell_'+u+''+j+'">';
			  
				tbody += '</td>'
				}
		tbody += '</tr>\n';
	}
	var tfooter = '</table></div>';
	document.getElementById('wrapper').innerHTML = theader + tbody + tfooter;
	document.getElementById('text_section').style.display="block";
	setrowcol();
  }
}
function setrowcol(){
$("#selected_row").empty();
$("#selected_col").empty();
var num_rows = document.getElementById('rows').value;
 var num_cols = document.getElementById('cols').value;
 var row_select='<option value ="0">Select Row</option>';
 var col_select='<option value ="0" >Select Col</option>';
			  for( var j=1; j<=num_rows; j++)
				{
				row_select += '<option value ="'+j+'">R '+j+'</option>';
				
				}
				for( var i=1; i<=num_cols; i++)
				{
				col_select += '<option value ="'+i+'">C '+i+'</option>';
				
				}
				$("#selected_row").append(row_select);
				  $("#selected_col").append(col_select);
}
function set_text(){
var cell_text=$('#cell_text').val();
var selected_row=$('#selected_row').val();
var selected_col=$('#selected_col').val();
if (selected_row == "" || selected_col == "" || selected_row == 0 || selected_col == 0 ) {
		alert("Please Select  Row and Column Both");
	} 
 else if (cell_text == "" || cell_text == null) {
		alert("Please enter text ");
	} 
 else {
		$("#cell_"+selected_row+''+selected_col).html(cell_text);
	   }        
}
function reset(id){
 document.getElementById('wrapper').innerHTML = "";
 document.getElementById('text_section').style.display="none";
 $('#cell_text').val('');
	if(id==1){
$('#rows').val('');
$('#cols').val('');
	}      
}
</script>
</body>
</html>
