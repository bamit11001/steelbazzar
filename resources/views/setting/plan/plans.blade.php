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

					<ul id="tabs-swipe-demo" class="tabs">
						<li class="tab"><a class="@if($tab == 'plan' ) active  @endif" href="#test-swipe-1">Plans</a></li>
						<li class="tab"><a class="@if($tab == 'planvalidity' ) active  @endif" href="#test-swipe-2">Plan Validity</a></li>
						<li class="tab"><a class="@if($tab == 'timetemplate' ) active  @endif" href="#test-swipe-3">Time Template</a></li>
					</ul>
					<div id="test-swipe-1">
						<h5>Plans</h5>
						@if (count($errors) > 0)
	                        @foreach ($errors->all() as $error)
	                            <div class="msg msg-error z-depth-3 scale-transition" > {{$error}}</div>
	                        @endforeach
	                    @endif
						@if(session()->has('message'))
						    <div class="msg msg-success z-depth-3 scale-transition" > 
						        {{ session()->get('message') }}</div>
						    </div>
						@endif
						<form id="addplan" method="post" action="{{ url('/saveplans') }}" name="addplan">
							{{ csrf_field() }}
							<div>
								<section>
									<div class="wizard-content">
										<div class="row">
											<div class="col m12">
												<div class="row">
													<div class="input-field col m6 s12">
														<label for="planname">Name</label>
														<input id="planname" name="planname" class="validate masked"  type="text" required>
													</div>
													<div class="input-field col m6 s12">
														<label for="shortname">Short Name</label>
														<input id="shortname" name="shortname" class="validate masked" type="text" required>
													</div>
													<div class="input-field col m6 s12">
														<select name="sort" id="sort" class="" autocomplete="off">
															<option value="" disabled selected>Choose your option</option>
															<option value="0">0</option>
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
														</select>
														<label>Priority</label>

													</div>
													<div class="input-field col m12 s12">
														<input type="checkbox" id="status" name="status" value="1" checked>
														<label for="status">Status</label>

													</div>
													<div class="input-field col m12 s12">
														<button type="submit" name="" id="submititem" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</form>
					</div>
					<div id="test-swipe-2" class="">
						<h5>Plans Validity</h5>
						@if(session()->has('message'))
						    <div class="msg msg-success z-depth-3 scale-transition" > 
						        {{ session()->get('message') }}
						    </div>
						@endif
						<form id="addplanvalidity" method="post" action="{{ url('/saveplansvalidity') }}" name="addplanvalidity">
							{{ csrf_field() }}
							<div>
								<section>
									<div class="wizard-content">
										<div class="row">
											<div class="col m12">
												<div class="row">
													<div class="input-field col m6 s12">
														<label for="validity_name">Name*</label>
														<input id="validity_name" name="validity_name" class="validate masked"  type="text" required>
													</div>
													<div class="input-field col m6 s12">
														<label for="validity">validity (months)*</label>
														<input id="validity" name="validity" class="validate masked" type="number" maxlength="2" required>
													</div>
													<div class="input-field col m6 s12">
														<label for="discount">discount</label>
														<input id="discount" name="discount" class="validate masked" type="text">
													</div>
													
													<div class="input-field col m6 s12">
														<select name="discount_type" id="discount_type" class="" autocomplete="off">
															<option value="" disabled selected>Discount Type</option>
															<option value="fixed">Fixed </option>
															<option value="percentage">Percentage</option>
														</select>
														<label>Discount Type</label>

													</div>
													<div class="input-field col m6 s12">
														<label for="maxdiscount">max discount</label>
														<input id="maxdiscount" name="maxdiscount" class="validate masked" type="text">
													</div>
													
													<div class="input-field col m12 s12">
														<input type="checkbox" id="status" name="status" value="1" checked>
														<label for="status">Status</label>

													</div>
													<div class="input-field col m12 s12">
														<button type="submit" name="" id="submititem" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</form>
					</div>
					<div id="test-swipe-3" class="">

						<h5>Plans</h5>
						@if(session()->has('message'))
						    <div class="msg msg-success z-depth-3 scale-transition" > 
						        {{ session()->get('message') }}
						    </div>
						@endif
						<form id="addtimetemplate" method="post" action="{{ url('/savetimetemplate') }}" name="addtimetemplate">
							{{ csrf_field() }}
							<div>
								<section>
									<div class="wizard-content">
										<div class="row">
											<div class="col m12">
												<div class="row">
													<div class="input-field col m6 s12">
														<label for="timetemplate">Time (24 hour format)*</label>
														<input id="timetemplate" name="timetemplate" class="validate masked" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" type="text" placeholder="HH:MM" maxlength="5"
														minlength="5" required>
													</div>
												
													<div class="input-field col m12 s12">
														<input type="checkbox" id="status" name="status" value="1" checked>
														<label for="status">Status</label>

													</div>
													<div class="input-field col m12 s12">
														<button type="submit" name="" id="submititem" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>


</main>
<script type="text/javascript">
	jQuery(document).ready(function() {
		 $('.maxdiscount').hide();
		// var instance = M.Tabs.getInstance(elem);
	});
	// $(function() {
	//   $('#discount_type').change(function(){
	   
	//     if($('#discount_type').val() != ''){
	//     		$('.maxdiscount').show();
	//     }
	//   });
	// });
</script>
@stop