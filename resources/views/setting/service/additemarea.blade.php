@extends('layouts.sidebar')
@section('content')
<?php //print_r($countries_available);die; ?>
<main class="mn-inner">
	<div class="row">
		<div class="col s12">
			<div class="page-title"></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<h5>add Area Item Link</h5>
					<div class="msg msg-error z-depth-3 scale-transition" style="display:none;"> </div>
					<div class="msg msg-success z-depth-3 scale-transition" style="display:none;"> </div>
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="msg msg-error z-depth-3 scale-transition" > {{$error}}</div>
                        @endforeach
                    @endif
      
					<form id="addcategoryform" method="post" action="{{ url('/additem_area') }}" name="addcategoryform">
						{{ csrf_field() }}
						<div>
							<section>
								<div class="wizard-content">
									<div class="row">
										<div class="col m12">
											<div class="row">

												<div class="input-field col m6 s12">
													<select name="Country" id="Country" class="materialSelect" autocomplete="off">
														<option value="" disabled selected>Choose Country</option>
														@foreach($countries_available as $country)
														<option value="{{$country[0]->countries->id}}">{{$country[0]->countries->name}}</option>
														@endforeach

													</select>
													<label>Country</label>

												</div>
												<div class="input-field col m6 s12">
													<select name="area" id="area" class="materialSelect" autocomplete="off">
														<option value="" disabled selected>Choose Area</option>
													</select>
													<label>Area</label>
												</div>

                                           <!--  <div class="input-field col m12 s12">
	                                             <input type="checkbox"  id="status" name="status" value="1">
                        						<label for="status">Status</label>
                        
                        					</div> -->


                        				</div>
                                        <div class="wizard-content">
                                            <div class="row">
                                                <div class="col m12">
                                                    <div class="row itemsview" >

                                                        <!-- @foreach($items as $key=>$item)
                                                            @if($key==0 || $key%2 == 0)<div class="row">@endif
                                                                <div class="input-field col m2 s4">
                                                                    <input type="checkbox"  id="items{{$item->id}}" name="items[{{$item->id}}][id]" value="{{$item->id}}">
                                                                    <label for="items{{$item->id}}">{{$item->name}}</label>
                                                                </div>

                                                                <div class="input-field col m2 s4">
                                                                    <input type="text"  id="price{{$item->id}}" name="items[{{$item->id}}][price]" value="20.00">
                                                                    <label for="price{{$item->id}}">price</label>
                                                                </div>
                                                                @if($key==0 || $key%2 == 0)<div class="input-field col m2 s4"></div>@endif
                                                                @if($key==1 || $key%2 == 1)</div>@endif
                                                            @endforeach -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        				
                        				<div class="row">
                        					<div class="input-field col m12 s12">
                        						<button type="submit" name="" id="submitcategory" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
                        					</div>
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
	$('.materialSelect').material_select();

        // setup listener for custom event to re-initialize on change
        $('.materialSelect').on('contentChanged', function() {
        	$(this).material_select();
        });
        jQuery(document).ready(function(){
        	$(document).on('change', "#Country", function(e){
        		var countryID = $(this).val();
        		console.log(countryID);
        		e.preventDefault();
        		jQuery.ajaxSetup({
        			headers: { 'csrftoken' : '{{ csrf_token() }}' }
        		});
        		jQuery.ajax({
        			url: "{{ url('/getcountryitem') }}",
        			method: 'post',
        			data: {

        				country_id: countryID,
        				_token: "{{ csrf_token() }}"
        			},
        			success: function(data){
        				if(data.success){
        					$("#area").empty();
        					$("#area").append('<option>Select</option>');
        					$.each(data.area_available,function(key,value){
			                	// console.log(key,value);
			                	$("#area").append('<option value="'+value.id+'">'+value.city_name+'</option>');
			                });
        					$("#area").trigger('contentChanged');
        				}else{
        					$("#area").empty();
        				}

        			}

        		});
        	});


            $(document).on('change', "#area", function(e){
                $(".itemsview").html('');
                var areaId = $(this).val();
                console.log(areaId);
                e.preventDefault();
                jQuery.ajaxSetup({
                    headers: { 'csrftoken' : '{{ csrf_token() }}' }
                });
                jQuery.ajax({
                    url: "{{ url('/getareaitems') }}",
                    method: 'post',
                    data: {

                        area_id: areaId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data){
                        if(data.success){
                            
                            $.each(data.items,function(key,value){
                                console.log(key,value);
                                 if(key == 0 || key%2 == 0)
                                 {
                                     $(".itemsview").append('<div class="row">');
                                 }
                                var checked = null;
                                if(value.servicestatus) checked = 'checked';
                                var price = '20.00';
                                if(value.price) price = value.price;
                                
                                $(".itemsview").append('<div class="input-field col m2 s4"> <input type="hidden"  id="items'+value.id+'" name="items['+value.id+'][id]" value="'+value.id+'" ><input type="checkbox"  id="status'+value.id+'" name="items['+value.id+'][status]" value="'+value.id+'" '+checked+'><label for="status'+value.id+'">'+value.name+'</label></div>');
                                $(".itemsview").append('<div class="input-field col m2 s4"><input type="text"  id="price{'+value.id+'" name="items['+value.id+'][price]" value="'+price+'"><label for="price'+value.id+'">price</label></div>');
                                if(key == 0 || key%2 == 0)
                                 {
                                     $(".itemsview").append('<div class="input-field col m2 s4"></div>');
                                 }
                                 if(key == 1 || key%2 == 1)
                                 {
                                     $(".itemsview").append('</div>');
                                 }
                               
                            });
                            Materialize.updateTextFields();
                        }else{
                           console.log("dghdgjghfghkj");
                        }

                    }

                });
            });
        });
        

    </script>
    @stop
