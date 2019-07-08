<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<meta name="csrf-token" content="{{csrf_token()}}">
       
	<script>
		window.Laravel = {
		   'csrfToken' : '{{csrf_token()}}',
		};
	 </script>
    <!-- Compiled and minified JavaScript -->
  <title>Document</title>
  <style>
     .metabase-container{
      border: 1px solid #000;
      padding: 37px;
      margin-top:10px; 
     }

     .add-search-box{
      border: 1px solid gray;
      padding: 8px;
      margin-top: 21px;
     }
     .search_value_add_item{
      background-color: cadetblue;
      width: 200px;
      text-align: center;
     }
     #list-container ul li {
      background-color: cadetblue;
      width: 70%;
      padding: 5px;
      margin: 3px;
     }
  
  </style>
</head>
<body>
    <div class="container">
         <div class="row metabase-container">
           <div class="col s4">
              <label>Table Field</label>
              <select class="browser-default" id="field_name">
                <option value="" disabled selected>Choose Attribute</option>
                  @foreach($columns as $col)
                  <option value="{{$col}}">{{$col}}</option>
                  @endforeach
              </select>
           </div>
           <div class="col s4">
                <div class="add-search-box">
                   Add Filters
                   <a style="margin-left: 170px;" id="add_filters" class="btn red modal-trigger disabled" href="#modal1">+</a>
                </div>
           </div>
           <div class="col s4">
              <label>Group By Field</label>
              <select class="browser-default" id="group_name">
                <option value="" disabled selected>Choose Attribute</option>
                  @foreach($columns as $col)
                  <option value="{{$col}}">{{$col}}</option>
                  @endforeach
              </select>
           </div>
         </div>
         <div class="row">
            
            <div class="col s6">
              <button id="get_result_btn" class="btn btn-primary">Get Answer</button>
            </div>
            <div class="col s6">
              <div id="list-container">
                  <ul>
                      @foreach ($field_val_arr as $item)
                      <li>{{$item}}
                        <button class="deleteItem btn btn-danger" style="color:brown;margin-top: -30px;margin-left: 269px;cursor:pointer;">x</button>
                      </li>
                      @endforeach
                  </ul>
              </div>
            </div>
         </div>
		 <div class="row">
				<div class="col s12">
						<table class="centered">
								<thead>
										<tr>
											<th>{{$group_name}}</th>
											<th>Row Count</th>
											
										</tr>
									</thead>
									<tbody>
										@foreach ($data as $item)
											<tr>
												<td>{{$item->$group_name}}</td>
												<td>{{$item->total}}</td>
												
											</tr>
										@endforeach
										
									</tbody>
						</table>
				</div>
					
		</div>
         
    </div>
    <input type="hidden" name="post_url" value="{{url('/autocomplete')}}">

      <div id="modal1" class="modal">
        <div class="modal-content">
            <form class="col s12" id="user_form" style="margin-top: 43px;">
                <div class="row">
                  <div class="input-field col s12">
                    <input list="suggesstion-box-ul" id="search_value" type="text" name="search_value" required>
                    <datalist id="suggesstion-box-ul">
                    </datalist>
                    <label for="search_value">Search Value</label>
                  </div>
                </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <a style="background-color: #469545;" id="search_value_add"  class="btn waves-effect waves-light right">Add Value</a>
                    </div>
                  </div>
            </form>
            <ul  id="search_val_container"></ul>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat" id="add_field">Add Field</a>
        </div>
      </div>

      <div id="modal2" class="modal">
        <div class="modal-content">
            
           
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat" id="add_field">Add Field</a>
        </div>
      </div>
      

      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var elems = document.querySelectorAll('.modal');
          var instances = M.Modal.init(elems, {preventScrolling:true});
        });
      </script>
      <script>
         $(document).ready(function(){
           $('#search_value_add').click(function(){

             var search_val = $("input[type=text][name=search_value]").val();
             var html = `<li class="search_value_add_item">
                          ${search_val}
                          <button class="deleteItem btn btn-danger"  style="color:white;cursor:pointer;margin-left: 90px;background-color: red;">x</button>
                        </li>`
             $("#search_val_container").append(html);
             console.log(search_val);
           })

           $('#add_field').click(function(){
               var filter_arr = Array(); 
               var listItems = $("#search_val_container li");
               var field_name = $('#field_name option:selected').val();
               listItems.each(function(idx, li){
                  var item = $(li);
                  filter_arr.push(item[0].innerText.slice(0,-1));
                });
                $('#search_val_container').empty();

                var filter_arr_str = filter_arr.join('-');
                var html =`<li>${field_name}-${filter_arr_str} <button class="deleteItem btn btn-danger" style="color:brown;margin-top: -30px;margin-left: 269px;cursor:pointer;">x</button></li>`;
                $('#list-container ul').append(html);
                $('#get_result_btn').removeClass('disabled');
                
           })


          $('#search_value').keyup(function(){
               var search_value = $(this).val();
               var field_name = $('#field_name option:selected').val();
               var item = $("input[type=hidden][name=post_url]").val();
               console.log(item);
               $.get(item+'/'+field_name+'/'+search_value, function(response, status){
                  console.log(response);
                  $('#suggesstion-box-ul').empty();
                  for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                              var html = `<option value="${response[key][field_name]}">`;
                              $('#suggesstion-box-ul').append(html);
                    }
                  }
               });
          });
          

          $('#get_result_btn').click(function(){
            console.log('Some thing happened');
            var listItems = $("#list-container ul li");
            var group_name = $('#group_name option:selected').val();
            
            if(group_name.length == 0){
              
              var filter_arr = [];
              listItems.each(function(idx, li){
                var item = $(li);
                filter_arr.push(item[0].innerText.slice(0,-1));
                
              });
              console.log(filter_arr);
              location.href = '/get-data/'+filter_arr;

            }else{
              
              var filter_arr = [];
              listItems.each(function(idx, li){
                var item = $(li);
                filter_arr.push(item[0].innerText.slice(0,-1));
                
              });
              console.log(filter_arr);
              if(filter_arr.length == 0){
                location.href = '/get-data-group-by/'+'none'+'/'+group_name;
              }else{
                location.href = '/get-data-group-by/'+filter_arr+'/'+group_name;
              }
              
            }
        })

          $('#field_name').on('change',function(){
                   $('#add_filters').removeClass('disabled');
                   var field_name = $('#field_name option:selected').val();
                   if(field_name === 'created_at' || field_name === 'updated_at'){
                     $('#add_filters').attr('href','#modal2');
                   }
            })
          })
         $(document).on("click", "button.deleteItem" , function() {
              $(this).parent().remove();
          });
      </script>
</body>
</html>




