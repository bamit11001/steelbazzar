@extends('layouts.sidebar')
@section('content')
<main class="mn-inner">
	<div class="row">
		<div class="col s12">
			<div class="page-title"></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<h5>Dashboard</h5>
					<div class="msg msg-error z-depth-3 scale-transition" style="display:none;"> </div>
					<div class="msg msg-success z-depth-3 scale-transition" style="display:none;"> </div>

					<form id="additemform" method="post" name="additemform">
						{{ csrf_field() }}
                                    <div>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m12">
                                                        <div class="row">
                                                 <div class="input-field col  s12">
	                                                <select  name="category" id="category" autocomplete="off">
	                                              <option value=""  disabled selected>Select Category</option>
	                                              @foreach($categories as $category)
	                                              <option value="{{$category->id}}" {{$item[0]->cat_id == $category->id  ? 'selected' : ''}}>{{$category->name}}</option>
	                                              @endforeach
	                                                </select>
	                                                <label>Category</label>
	                                            </div>


                                            <div class="input-field col m6 s12">
	                                            <label for="item">Item Name</label>
	                                            <input  id="item" name="item" class="masked" type="text" value="{{$item[0]->name}}" required>

                                            </div>
                                            <div class="input-field col m6 s12">
	                                            <select name="sort" id="sort" autocomplete="off">
												      <option value="" disabled selected>Choose your option</option>
												      @for ($i = 1; $i <= 5; $i++)
												      	<option value="{{$i}}" {{$item[0]->sort == $i  ? 'selected' : ''}}>{{$i}}</option>
												      @endfor
												      
													    </select>
													    <label>Priority</label>
	                                            
                                            </div>
                                            <div class="input-field col m12 s12">
	                                             <input type="checkbox"  id="status" name="status" value="1" @if($item[0]->status == '1' ) checked @endif>
                        						<label for="status">Status</label>
                        
                                            </div>
   										<div class="input-field col m12 s12">
                                          <button type="submit"  id="submititem" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
                                      </div>
   

                                                                                               

                                                </div>
                                            </div>
                                        </section>
                                        </section>
                                    </div>
                    </form>
				</div>
			</div>
		</div>
</div>


</main>
<script type="text/javascript">

         jQuery(document).ready(function(){
            jQuery('#submititem').click(function(e){
            	jQuery('#submititem').attr("disabled", true);
               e.preventDefault();
               jQuery.ajaxSetup({
                  headers: { 'csrftoken' : '{{ csrf_token() }}' }
              });
               jQuery.ajax({
                  url: "{{ url('/updateitem') }}",
                  method: 'post',
                  data: {
                     category: jQuery('#category').val(),
                     item: jQuery('#item').val(),
                     sort: jQuery('#sort').val(),
                     item_id: "{{$item[0]->id}}",
                     status: jQuery('#status').prop('checked')?"1":"0",
                     _token: "{{ csrf_token() }}"
                  },
                  success: function(data){
	                  	if(data.success){
	                  		jQuery('.msg-error').hide();
	                  		
	              			jQuery('.msg-success').show();
                  			jQuery('.msg-success').append('<p>'+data.success+'</p>');
	                  		setTimeout(function() {
	                  			jQuery('.msg-success').hide();
		              		}, 5000);
	                  		
	                  	}
	                  	if(data.errors){
	                  		jQuery('.msg-error').html('');
	                  		jQuery('#submititem').attr("disabled", false);
	                  	}
	                  	
	              		jQuery.each(data.errors, function(key, value){
	              			jQuery('.msg-error').show();
	              			jQuery('.msg-error').append('<p>'+value+'</p>');
	              		});
	              		setTimeout(function() {
	              			jQuery('.msg-error').hide();
	              		}, 5000);
                	}
                    
                  });
               });
            });
</script>
@stop
