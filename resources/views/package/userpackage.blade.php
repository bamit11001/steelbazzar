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
					<h5 id="app">@{{title}}</h5>

<form id="addplan" method="post" action="{{ url('/saveplans') }}" name="addplan">
							{{ csrf_field() }}
							<div>
								<section>
									<div class="wizard-content">
										<div class="row">
											<div class="col m12">
												<!-- <div class="row">
												
													<div class="input-field col m3 s12">
														<select name="item" id="item" class="" autocomplete="off">
															<option value="" disabled selected>Choose Items</option>
															
														</select>
														<label>Item</label>

													</div>
													<div class="input-field col m3 s12">
														<select class="form-control js-example-tags" multiple="multiple">
														  <option selected="selected">orange</option>
														  <option>white</option>
														  <option selected="selected">purple</option>
														</select>
													

													</div>
													<div class="input-field col m3 s12">
													</div>
													<div class="input-field col m3 s12">
													</div>
													
													
												</div> -->
												<div class="row" v-for="(package, index) in packageUnder" :key="index">

													<div class="input-field col m3 s12">
														<select name="item"  v-model="package.item" class="browser-default" autocomplete="off">
															<option value="" disabled selected>Choose Items</option>
															<option value="ghdgfg">fhfhff</option>
														</select>
														<label>Item</label>

													</div>

													<div class="input-field col m3 s12">
														<select class="form-control browser-default "  multiple="multiple" v-model="package.area">
														  <option >orange</option>
														  <option>white</option>
														  <option >purple</option>
														  <option>white</option>
														  <option >purple</option>
														  <option>white</option>
														 
														</select>
													

													</div>

											   <!--  <div class="col-md-4">
											        <div class="form-group label-floating">
											            <label class="control-label">Act @{{index}}</label>
											            <input type="text" class="form-control" v-model="package.act" >
											        </div>
											    </div>
											    <div class="col-md-4">
											        <div class="form-group label-floating">
											            <label class="control-label">Section @{{index}}</label>
											            <input type="text" class="form-control" v-model="package.section">
											        </div>
											    </div> -->
											   <!--  <div class="input-field col m12 s12">
														<button type="submit" name="" id="submititem" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
												</div> -->
											</div>
											<button type="button" @click="addNewRow">Add row</button>
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


	$(".js-example-tags").select2({
	  tags: true
	});
</script>
<script>
	var app = new Vue({
	  el: '#app',
	  data: {
	    title: 'Area And Item Link'
	  }
	})




addForm = new Vue({
    el: "#addplan",
    data: {
        packageUnder:[
          {
             item: null,
             area: null,
          },
        ],
    },
    methods: {
        addNewRow: function() {
          this.packageUnder.push({ item: null, area: null, });
          $(".materialSelect").trigger('contentChanged');
          
        },
        handleSubmit: function(e) {
            var vm = this;
            $.ajax({
                url: 'http://localhost:3000/record/add/f/',
                data: vm.packageUnder,
                type: "POST",
                dataType: 'json',
                success: function(e) {
                    if (e.status) {
                        vm.response = e;
                        alert("success")
                    } else {
                        vm.response = e;
                        console.log(vm.response);
                        alert(" Failed") 
                    }
                }
            });
            return false;
        }, 
    },
});

</script>
@stop
