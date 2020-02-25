@extends('layouts.sidebar')
@section('content')

<?php  ?>
<main class="mn-inner">
	<div class="row">
		<div class="col s12">
			<div class="page-title"></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<h5>Area And Item Link</h5>
<button name="addItem" class="btn btn-info right" > <i class="icon-plus-sign"></i><a id="index" class="navbar-brand" href="{{route('addItemArea')}}">Add Item Area Link</a></button>
					<!-- <div class="container">
						    <table id="myTable" class="table order-list">
						    <thead>
						        <tr>
						            <td>Name</td>
						            <td>Gmail</td>
						            <td>Phone</td>
						        </tr>
						    </thead>
						    <tbody>
						        <tr>
						            <td class="col-sm-4">
						               <select  name="item" class="materialSelect" id="item" autocomplete="off">
                                              <option value=""  disabled selected>Select Item</option>
                                              @foreach($item as $itm)
                                              		<option value="{{$itm->id}}" >{{$itm->name}}</option>
                                              @endforeach
                                        </select>
						            </td>
						            <td class="col-sm-4">
						                <input type="mail" name="mail"  class="form-control"/>
						            </td>
						            <td class="col-sm-3">
						                <input type="text" name="phone"  class="form-control"/>
						            </td>
						            <td class="col-sm-2"><a class="deleteRow"></a>

						            </td>
						        </tr>
						    </tbody>
						    <tfoot>
						        <tr>
						            <td colspan="5" style="text-align: left;">
						                <input type="button" class="btn btn-lg btn-block " id="addrow" value="Add Row" />
						            </td>
						        </tr>
						        <tr>
						        </tr>
						    </tfoot>
						</table>
						</div> -->



					<!-- <form id="additemform" method="post" name="additemform">
						{{ csrf_field() }}
						<div>
							<section>
									<div class="row">
										<div class="col m12">
											<div id="row1" class="row">
													
													<div class="input-field col m4 s6">
														<select  name="item" class="materialSelect" id="item" autocomplete="off">
				                                              <option value=""  disabled selected>Select Item</option>
				                                              @foreach($item as $itm)
				                                              		<option value="{{$itm->id}}" >{{$itm->name}}</option>
				                                              @endforeach
		                                                </select>
		                                                <label>Item</label>
													</div>
													<div class="input-field col m4 s6">
														<select  name="area" id="area" class="materialSelect" autocomplete="off">
				                                              <option value=""  disabled selected>Select Item</option>
				                                              @foreach($areas as $area)
				                                              		<option value="{{$area->id}}" >{{$area->city_name}}</option>
				                                              @endforeach
		                                                </select>
		                                                <label>Area</label>
													</div>
													<div class="input-field col m4 s6">
														<label for="price">Price</label>
	                                            		<input id="price" name="price" class="masked" type="text" value="" required>

													</div>
											</div>
											<div class="row">
												<a class="btn btn-default right" id="Add2" role="button"><span class="glyphicon glyphicon-plus">+</span>&nbsp;</a>
											</div>
											<div class="row">
												<div class="input-field colm12 s12">
													<button type="submit" name="" id="submititem" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
												</div>
											</div>

										</div>
									</div>
								</section>
							</div>
						</form> -->




						<table id="areaTable" class="display responsive-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Region</th>
									<th class="text-center">Area</th>
									<th class="text-center">Item</th>
									<th class="text-center">Price</th>
									<!-- <th class="text-center">Status</th> -->
									<!-- <th class="text-center">Actions</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach($services as $key => $service)
								<tr class="item{{$key}}">
									<td>{{$key+1}}</td>
									<td>{{$service->area->countries->name}}</td>
									<td>{{$service->area->city_name}}</td>
									<td>{{$service->item->name}}</td>
									<td>{{$service->price}}</td>
									<!-- <td>{{$service->status?'Active':'Inactive'}}</td> -->
									<!-- <td><a href="{{ route('editarea', ['id' => $service->id]) }}" class="btn btn-success btn-line btn-rect">
										<i class="icon-pencil icon-white"></i> Edit
									</a>
								</td> -->
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>
<script>
		$('.materialSelect').material_select();

        // setup listener for custom event to re-initialize on change
        $('.materialSelect').on('contentChanged', function() {
        $(this).material_select();
        });
	var newId = 1;
	$(document).ready(function() {
		$('#areaTable').DataTable();
	} );


$(document).ready(function () {
    var counter = 0;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" name="name' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="mail' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" name="phone' + counter + '"/></td>';

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});



function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}


	// $(document).on('click','#Add2',function() {
	// 	newId = (newId *1)+(1*1);
		
	//     	var clone = $('#row1').clone();
	//     	// newId = "row"+(newId *1)+ 1;
	// 		clone.attr("id", "row"+newId);
	// 		clone.find("#item").attr("id","item-"+newId);
	// 		var aaa = newId-1;
	// 		console.log(aaa);
	// 		$("#row"+aaa).after(clone); 
	// 		$("item-"+newId).trigger('contentChanged');
	// 	});
	
</script>
@stop
