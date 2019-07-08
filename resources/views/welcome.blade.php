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
      border: 4px solid darkcyan;
      padding: 37px;
      margin-top:10px; 
     }

     .add-search-box{
      border: 1px solid gray;
      padding: 5px;
      margin-top: 21px;
     }
     .search_value_add_item{
      background-color: cadetblue;
      width: 100%;
      margin: 5px;
     }
     #list-container ul li {
      background-color: cadetblue;
      width: 70%;
      padding: 5px;
      margin: 3px;
     }
     .modal-custom { width: 30% !important ; height: 65% !important ; }
  </style>
</head>
<body>
   
      <div id="app">
         
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
                   <div id="list-container">
                       <ul>
                          
                       </ul>
                   </div>
                 </div>
                 <div class="col s3">
                   <button id="get_result_btn" class="btn btn-primary">Get Answer</button>
                 </div>
                 <div class="col s3">
                  <button class="btn waves-effect waves-light red lighten-2"><a href="{{route('index')}}" style="color:white">Reset</a></button>
                </div>
              </div>
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
         <input type="hidden" name="post_url"  value="{{url('/autocomplete')}}">
         <input type="hidden" name="result_url"  value="{{url('/')}}">
     
          <div id="modal1" class="modal modal-custom">
             <div class="modal-content">
                 <form class="col s12" id="user_form" style="margin-top: 43px;">
                     <div class="row" id="add_attribute_value">
                       <div class="input-field col s12">
                         <input list="suggesstion-box-ul" id="search_value" type="text" name="search_value" required>
                         <datalist id="suggesstion-box-ul">
                         </datalist>
                         <label for="search_value">Search Value</label>
                       </div>
                     </div>
                       <div class="row">
                         <div class="input-field col s12">
    
                           <a style="background-color: #2196F3;margin-right: 36%;" id="search_value_add"  class="btn waves-effect waves-light right">Add Value</a>

                         </div>
                       </div>
                 </form>
                 <ul  id="search_val_container"></ul>
                 <a href="#!" style="background-color: #00BCD4;color: white;margin-bottom: 5px;float:right;" class="modal-close waves-effect waves-green btn-flat" id="add_field">Submit</a>
             </div>
          </div>
          <div id="modal3" class="modal modal-custom">
              <div class="modal-content">
                  <form class="col s12" id="user_form" style="margin-top: 43px;">
                      <div class="row" id="add_attribute_value">
                        <div class="input-field col s4">
                            <select class="browser-default" id="time_option">
                              <option  value="" disabled selected>Time Option</option>
                              <option value="current">Current</option>
                              <option value="previous">Previous</option>
                            </select>
                              
                        </div>
                        <div class="input-field col s4">
                            <select class="browser-default" id="time_option_type">
                              <option value="day" selected>Day</option>
                              <option value="month">Month</option>
                              <option value="week">Week</option>
                            </select>
                        </div>
                        <div class="input-field col s4">
                            <input placeholder="Placeholder" id="time_value" name="time_value" type="text" class="validate">
                            <label for="time">Value</label>
                        </div>
                      </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <a style="background-color: #2196F3;margin-right: 36%;" id="search_value_add"  class="btn waves-effect waves-light right">Add Value</a>
                          </div>
                        </div>
                  </form>
                  <ul  id="search_val_container_ul"></ul>
                  <a href="#!" style="background-color: #00BCD4;color: white;margin-bottom: 5px;float:right;" class="modal-close waves-effect waves-green btn-flat" id="add_field_time">Submit</a>
          </div>

           
          
         </div>
      

      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      {{-- <script src="{{asset('js/app.js')}}"></script> --}}
      <script>
        document.addEventListener('DOMContentLoaded', function(){
          var elems = document.querySelectorAll('.modal');
          var instances = M.Modal.init(elems, {preventScrolling:true});
        });
      </script>
      <script>
        $(document).ready(function(){
          $('#add_field').click(function(){
              var filter_arr = Array(); 
              var listItems = $("#search_val_container li");
              var field_name = $('#field_name option:selected').val();
            
              listItems.each(function(idx, li){
                var item = $(li);
                filter_arr.push(item[0].innerText.slice(0,-1));
              });
              if(filter_arr.length === 0){
                  return;
              }else{
                $('#search_val_container').empty();
                var filter_arr_str = filter_arr.join('-');
                var html =`<li>${field_name}-${filter_arr_str} <button class="deleteItem btn btn-danger" style="color:brown;margin-top: -30px;margin-left: 269px;cursor:pointer;">x</button></li>`;
                $('#list-container ul').append(html);
                $('#get_result_btn').removeClass('disabled');
              }   
        })

        $('#add_field_time').click(function(){
              var filter_arr = Array(); 
              var listItems = $("#search_val_container_ul li");
              var field_name = $('#field_name option:selected').val();
              
              listItems.each(function(idx, li){
                var item = $(li);
                filter_arr.push(item[0].innerText.slice(0,-1));
              });
              if(filter_arr.length === 0){
                  return;
              }else{
                $('#search_val_container_ul').empty();
                var filter_arr_str = filter_arr.join('-');
                var html =`<li>${field_name}-${filter_arr_str} <button class="deleteItem btn btn-danger" style="color:brown;margin-top: -30px;margin-left: 269px;cursor:pointer;">x</button></li>`;
                $('#list-container ul').append(html);
                $('#get_result_btn').removeClass('disabled');
              }   
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
          var url = $("input[type=hidden][name=result_url]").val();
          if(group_name.length == 0){
            
            var filter_arr = [];
            listItems.each(function(idx, li){
              var item = $(li);
              filter_arr.push(item[0].innerText.slice(0,-1));
              
            });
            //console.log(filter_arr);
            $.get(url+'/get-data/'+filter_arr,function(response,status){
              $('tbody').empty();
              var html = "";
              console.log(response);
                  $.each(response,function(key,val){
                    html += `<tr>
                                  <td>${val.id}</td>
                                  <td>${val.name}</td>
                                  <td>${val.email}</td>
                                  <td>${val.contact_no}</td>
                                  <td>${val.customer_id}</td>
                                  <td>${val.pickup}</td>
                                  <td>${val.dropoff}</td>
                                  <td>${val.institution}</td>
                                  <td>${val.remarks}</td>
                                  <td>${val.campaign_id}</td>
                                  <td>${val.created_at}</td>
                                </tr>`;
                  })
                  $('tbody').append(html);
            })

          }else{
            
            var filter_arr = [];
            listItems.each(function(idx, li){
              var item = $(li);
              filter_arr.push(item[0].innerText.slice(0,-1));
              
            });
            console.log(filter_arr);
            if(filter_arr.length == 0){
              //location.href = '/get-data-group-by/'+'none'+'/'+group_name;
              $.get(url+'/get-data-group-by/none/'+group_name,function(response,status){
              $('table').empty();
              var html = `<thead>
                            <tr>
                              <td class="center">${group_name}</td>
                              <td class="center">Row Count</td>
                            </tr>
                          </thead>`;
             
                  $.each(response,function(key,val){
                    html += `<tbody>
                                  <tr>
                                    <td>${val[group_name]}</td>
                                    <td>${val.total}</td>
                                  </tr>
                              </tbody>`
                                
                  })
                  $('table').append(html);
            })
            }else{
              //location.href = '/get-data-group-by/'+filter_arr+'/'+group_name;
              $.get(url+'/get-data-group-by/'+filter_arr+'/'+group_name,function(response,status){
              $('table').empty();
              var html = `<thead>
                            <tr>
                              <td class="center">${group_name}</td>
                              <td class="center">Row Count</td>
                            </tr>
                          </thead>`;
              console.log(response);
                  $.each(response,function(key,val){
                    html += `<tbody>
                                  <tr>
                                    <td>${val[group_name]}</td>
                                    <td>${val.total}</td>
                                  </tr>
                              </tbody>`
                                
                  })
                  $('table').append(html);
              })
            }
            
          }
        })

        $('#field_name').on('change',function(){
                  $('#add_filters').removeClass('disabled');
                  var field_name = $('#field_name option:selected').val();
                  if(field_name == 'created_at' || field_name == 'updated_at'){
                    $('#add_filters').attr('href','#modal3');
                  }else{
                    $('#add_filters').attr('href','#modal1');
                  }
          })
        })

       $(document).on('click','#search_value_add',function(){
        var field_name = $('#field_name option:selected').val();
            if(field_name === 'created_at' || field_name === 'updated_at'){
                var time_option = $('#time_option option:selected').val();
                var time_option_type = $('#time_option_type option:selected').val();
                var time_value = $('input[type=text][name=time_value]').val();
                var html;
                if(time_value === null){
                  var search_val = time_option +"-"+time_option_type;
                   html = `<li class="search_value_add_item">
                          ${search_val}
                          <button class="deleteItem btn btn-danger"  style="color:white;cursor:pointer;margin-left: 237px;;background-color: red;">x</button>
                        </li>`
                    $("#search_val_container_ul").append(html);
                }else{
                  var search_val = time_option +"-"+time_option_type+"-"+time_value;
                   html = `<li class="search_value_add_item">
                                ${search_val}
                                <button class="deleteItem btn btn-danger"  style="color:white;cursor:pointer;margin-left: 237px;;background-color: red;">x</button>
                              </li>`
                  $("#search_val_container_ul").append(html);
                }
                
                //console.log(search_val);
            }else{
              var search_val = $("input[type=text][name=search_value]").val();
               html = `<li class="search_value_add_item">
                          ${search_val}
                          <button class="deleteItem btn btn-danger"  style="color:white;cursor:pointer;margin-left: 237px;;background-color: red;">x</button>
                        </li>`
                $("#search_val_container").append(html);
            }
            //console.log(html)
            
            //console.log(field_name);
       })
        
        $(document).on('change','#time_option',function(){
          var time_option = $('#time_option option:selected').val();
          if(time_option === 'current'){
             $('#time_value').attr('disabled', true);
          }else{
             $('#time_value').attr('disabled', false);
          }
        })
        $(document).on("click", "button.deleteItem" , function() {
            $(this).parent().remove();
        });
      </script>
</body>
</html>