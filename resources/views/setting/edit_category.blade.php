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

					<form id="addcategoryform" method="post" name="addcategoryform">
						{{ csrf_field() }}
                                    <div>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m12">
                                                        <div class="row">
                                            <div class="input-field col m6 s12">
	                                            <label for="category">Category Name</label>
	                                            <input  id="category" name="category" class="masked" type="text" value="{{$categories[0]->name}}" required>
                                            </div>
                                            <div class="input-field col m6 s12">
	                                            <select name="sort" id="sort" autocomplete="off">
												      <option value="" disabled selected>Choose your option</option>
												      @for ($i = 1; $i <= 5; $i++)
												      	<option value="{{$i}}" {{$categories[0]->sort == $i  ? 'selected' : ''}}>{{$i}}</option>
												      @endfor
												      
													    </select>
													    <label>Priority</label>
	                                            
                                            </div>
                                            <div class="input-field col m12 s12">
	                                             <input type="checkbox"  id="status" name="status" value="1" @if($categories[0]->status == '1' ) checked @endif>
                        						<label for="status">Status</label>
                        
                                            </div>
   										<div class="input-field col m12 s12">
                                          <button type="submit" name="" id="submitcategory" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
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
            jQuery('#submitcategory').click(function(e){
            	jQuery('#submitcategory').attr("disabled", true);
               e.preventDefault();
               jQuery.ajaxSetup({
                  headers: { 'csrftoken' : '{{ csrf_token() }}' }
              });
               jQuery.ajax({
                  url: "{{ url('/updatecategory') }}",
                  method: 'post',
                  data: {
                    
                     category: jQuery('#category').val(),
                     sort: jQuery('#sort').val(),
                     category_id: "{{$categories[0]->id}}",
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
	                  		jQuery('#submitcategory').attr("disabled", false);
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
