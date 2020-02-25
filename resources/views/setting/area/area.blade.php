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
					<h5>Area</h5>
					<button name="addArea" class="btn btn-info right" > <i class="icon-plus-sign"></i><a id="index" class="navbar-brand" href="{{route('addarea')}}">Add Area</a></button>
					<table id="areaTable" class="display responsive-table">
                                    <thead>
								        <tr>
								            <th class="text-center">#</th>
								            <th class="text-center">Area Name</th>
								            <th class="text-center">Priority</th>
								            <th class="text-center">Status</th>
								            <th class="text-center">Actions</th>
								        </tr>
								    </thead>
								    <tbody>
									@foreach($areas as $area)
									<tr class="item{{$area->id}}">
									    <td>{{$area->id}}</td>
									    <td>{{$area->city_name}}</td>
									    <td>{{$area->sort}}</td>
									    <td>{{$area->status}}</td>
									    <td><a href="{{ route('editarea', ['id' => $area->id]) }}" class="btn btn-success btn-line btn-rect">
										    <i class="icon-pencil icon-white"></i> Edit
										</a>
									        </td>
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
  $(document).ready(function() {
    $('#areaTable').DataTable();
} );
 </script>
@stop
