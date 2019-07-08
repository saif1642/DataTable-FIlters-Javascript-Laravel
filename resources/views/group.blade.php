<!DOCTYPE html>
<html lang="en">
<head>
  <title>Data Filter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	

</head>
<body>

<div class="container">
  
	<div class="row">
		<div class="col s3">Passenger</div>
		<div class="col s3">
			<div class="form-group">
				<select  name="field_name" id="field_name" class="form-control">
					    <option disabled selected>Filter Value</option>
						@foreach($columns as $col)
						<option value="{{$col}}">{{$col}}</option>
						@endforeach
				</select>
			</div>
			
		</div>
		<div class="col s3">
			<div class="form-group" id="search_value_area" style="display:none">
				<input list="suggesstion-box-ul" type="text" class="form-control" name="search_value" id="search_value">
					<datalist id="suggesstion-box-ul">
					</datalist>
					{{-- <select class="js-example-basic-multiple" style="width:250px"  id="id-select2-multi" name="itemName[]" multiple="multiple">
						<option value="AL">Alabama</option>
						<option value="WY">Wyoming</option>
					</select> --}}
			</div>

			<div class="row" id="created_at_option" style="display:none">
					<div class="col s4">
						<div class="form-group">
							<select class="form-control" id="created_at_option_select">
								<option value="previous">Previous</option>
								<option value="current">Current</option>
							</select>
						</div>
					</div>
					<div class="col s4">
						<div class="form-group" id="created_at_search" style="display:block">
							<input type="text" class="form-control"  name="created_at_search">
						</div>
					</div>
					<div class="col s4">
							<div class="form-group">
									<select class="form-control" id="created_at_timing_select">
										<option value="day">Days</option>
										<option value="week">Weeks</option>
										<option value="month">Months</option>
									</select>
							</div>
					</div>
			</div>
		</div>
		<div class="col s3">
			<div class="form-group">
				<select  name="group_name" id="group_name" class="form-control">
					    <option disabled selected>Group By</option>
						@foreach($columns as $col)
						<option value="{{$col}}">{{$col}}</option>
						@endforeach
				</select>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="col s4">
				<ul class="list-group" id="all_filter_option">
						@foreach ($field_val_arr as $item)
							<li class="list-group-item">{{$item}} <button  class="deleteItem btn btn-danger" style="color:brown;margin-left: 234px;cursor:pointer;">x</button></li>
						@endforeach
				</ul>
		</div>
		<div class="col s4">
			<button id="add_btn" class="btn btn-primary">ADD Field</button>
		</div>
		<div class="col s4">
			<button id="get_ans_btn" class="btn btn-info">Get Answer</button> 
			<button id="get_ans_btn" class="btn btn-warning"><a href="{{url('/group-view')}}">Refresh</a></button>
			<button id="add_value" class="btn btn-danger" style="display:none">Add Value</button>
			<p id="search_value_id" style="margin-top: 8px"></p>
		</div>
	</div>
	<br>
	<br>

	<div class="row">
			<div class="col s12">
					<table class="centered">
							<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>Contact No</th>
										<th>Customer ID</th>
										<th>Pick Up</th>
										<th>Drop Off</th>
										<th>Institution</th>
										<th>Remarks</th>
										<th>Campaign ID</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($passengers as $item)
										 <tr>
											 <td>{{$item->id}}</td>
											 <td>{{$item->name}}</td>
											 <td>{{$item->email}}</td>
											 <td>{{$item->contact_no}}</td>
											 <td>{{$item->customer_id}}</td>
											 <td>{{$item->pickup}}</td>
											 <td>{{$item->dropoff}}</td>
											 <td>{{$item->institution}}</td>
											 <td>{{$item->remarks}}</td>
											 <td>{{$item->campaign_id}}</td>
											 <td>{{$item->created_at}}</td>
										 </tr>
									@endforeach
									
								</tbody>
					</table>
			</div>
				
	</div>	
		
</div>




<input type="hidden" name="post_url" value="{{url('/autocomplete')}}">

<script>



 $(document).ready(function(){
	 $('#field_name').on('change',function(){
		 var field_name = $('#field_name option:selected').val();
		 if(field_name === 'id'){
						$('#search_value_area').css('display','block');
						$('#created_at_option').css('display','none');
						$('#add_value').css('display','block');

		 }
		 else if(field_name === 'customer_id'){
						$('#search_value_area').css('display','block');
						$('#created_at_option').css('display','none');
						$('#add_value').css('display','block');

		 }
		 else if(field_name === 'campaign_id'){
						$('#search_value_area').css('display','block');
						$('#created_at_option').css('display','none');
						$('#add_value').css('display','block');

		 }
		 else if(field_name === 'name'){
						$('#search_value_area').css('display','block');
						$('#created_at_option').css('display','none');
						$('#add_value').css('display','block');

					
		 }
		 else if(field_name === 'email' || field_name === 'institution' || field_name === 'remarks'){
						$('#search_value_area').css('display','block');
						$('#created_at_option').css('display','none');
						$('#add_value').css('display','block');

		 }
		 else if(field_name === 'contact_no' || field_name === 'pickup' || field_name === 'dropoff'){
						$('#search_value_area').css('display','block');
						$('#created_at_option').css('display','none');
						$('#add_value').css('display','block');
		 }
		 else if(field_name === 'created_at' || field_name === 'updated_at'){
			      $('#search_value_area').css('display','none');
			      $('#created_at_option').css('display','block');
				  $('#add_value').css('display','none');
		 }
		 else{
			$('#search_value_area').css('display','none');
		 }

})

$('#add_btn').click(function(){
	// var values = $('#id-select2-multi').val();
	// console.log(values);
	var search_values = $('#search_value_id').text();
	
	var field_name = $('#field_name option:selected').val();
	if(field_name === 'created_at' || field_name === 'updated_at'){
		var created_at_option_select = $('#created_at_option_select option:selected').val();
		if(created_at_option_select == 'current'){
			//$('#created_at_search').css('display','none');
			var created_at_search = "none";
		}else{
		var created_at_search = $("input[type=text][name=created_at_search]").val();
		}
		
		var created_at_timing_select = $('#created_at_timing_select option:selected').val();
		var html = `<li class="list-group-item">
			${field_name}-${created_at_option_select}-${created_at_search}-${created_at_timing_select}
			<button class="deleteItem btn btn-danger" style="color:brown;margin-left: 302px;cursor:pointer;">x</button>
			</li>`;
		$('#all_filter_option').append(html);
		console.log(created_at_option_select + ' '+ created_at_search+' '+created_at_timing_select);
	}else{
		var search_value = $("input[type=text][name=search_value]").val();
		var search_values = $('#search_value_id').text();
		var html = `<li class="list-group-item">
			${field_name}-${search_values}
			<button class="deleteItem btn btn-danger"  style="color:brown;margin-left: 234px;cursor:pointer;">x</button>
			</li>`;
		if(search_value.length != 0){
			$('#all_filter_option').append(html);
		}
	}
	$('#search_value_id').empty();
	
})

$('#add_value').click(function(){
	var search_value = $("input[type=text][name=search_value]").val();
	var current_p = $('#search_value_id').append(search_value+'-')
	
})

$('#get_ans_btn').click(function(){
	console.log('Some thing happened');
	var listItems = $("#all_filter_option li");
	var group_name = $('#group_name option:selected').val();
	if(group_name === "Group By"){
		
		var filter_arr = [];
		listItems.each(function(idx, li){
			var item = $(li);
			filter_arr.push(item[0].innerText.slice(0,-1));
			
		});
		console.log(filter_arr);
		location.href = '/get-data/'+filter_arr;

	}else{
		console.log(group_name);
		var filter_arr = [];
		listItems.each(function(idx, li){
			var item = $(li);
			filter_arr.push(item[0].innerText.slice(0,-1));
			
		});
		if(filter_arr.length == 0){
			location.href = '/get-data-group-by/'+'none'+'/'+group_name;
		}else{
			location.href = '/get-data-group-by/'+filter_arr+'/'+group_name;
		}
		
	}
	
	

})

$("#search_value").keyup(function() {
	var search_value = $(this).val();
	console.log(search_value);
	var item = $("input[type=hidden][name=post_url]").val();
	var field_name = $('#field_name option:selected').val();
	var autocompleteData = Array();

	$.get(item+'/'+field_name+'/'+search_value, function(response, status){
		console.log(response);
		$('#suggesstion-box-ul').empty();
		for (var key in response) {
		if (response.hasOwnProperty(key)) {
							autocompleteData.push(response[key][field_name]);
							var html = `<option value="${response[key][field_name]}">`;
							$('#suggesstion-box-ul').append(html);
		}
	}
			
	});
});

	//  $('.deleteItem').on('click',function(){
	// 	 console.log($(this).parent());
	// 	 $(this).parent().remove();
	//  })

	 

	//  $('#id-select2-multi').on('select2:open', function (e) {
	// 	var data = e.params.data;
	// 	var item = $("input[type=hidden][name=post_url]").val();
	// 	var field_name = $('#field_name option:selected').val();
	// 	console.log('data');
	// 	$.get(item+'/'+field_name+'/'+1, function(response, status){
			
	// 		//  $('#suggesstion-box-ul').empty();
	// 	    	for (var key in response) {
    //             if (response.hasOwnProperty(key)) {
								 
	// 			    var html = `<option value="${response[key][field_name]}">${response[key][field_name]}</option>`;
								 
    //             }
	// 			console.log(html);
	// 			$('#id-select2-multi').append(html);
    //       }
					
	// 		});
    // });

	
 })

 $(document).on("click", "button.deleteItem" , function() {
    $(this).parent().remove();
});

//  // AJAX call for autocomplete 
// $(document).ready(function(){
// 	$("#search_value").keyup(function(){
// 		 var search_value = $(this).val();
// 		 var item = $("input[type=hidden][name=post_url]").val();
// 		 var field_name = $('#field_name option:selected').val();
// 		$.ajax({
// 		type: "POST",
// 		url: "readCountry.php",
// 		data:'keyword='+$(this).val(),
// 		beforeSend: function(){
// 			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
// 		},
// 		success: function(data){
// 			$("#suggesstion-box").show();
// 			$("#suggesstion-box").html(data);
// 			$("#search-box").css("background","#FFF");
// 		}
// 		});
// 	});
// });
// //To select country name
// function selectCountry(val) {
// $("#search-box").val(val);
// $("#suggesstion-box").hide();
// }

let deleteBtn = document.getElementsByClassName("deleteItem");
console.log(deleteBtn);
Array.prototype.slice.call(deleteBtn).forEach(function(item) {
  // iterate and add the event handler to it
  item.addEventListener("click", function(e) {
    e.target.parentNode.remove();
	console.log('Clicked');

  });

})






</script>
</body>
</html>
