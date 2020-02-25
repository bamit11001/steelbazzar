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
				
				</div>
			</div>
		</div>
</div>
</main>
<script>
  $(document).ready(function() {
    $('#itemTable').DataTable();
} );
 </script>
@stop
