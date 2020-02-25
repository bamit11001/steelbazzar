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
					<h5>Items</h5>
					<button name="addItem" class="btn btn-info right" > <i class="icon-plus-sign"></i><a id="index" class="navbar-brand" href="{{route('additem')}}">Add Item</a></button>
					<table id="itemTable" class="display responsive-table ">
                                    <thead>
								        <tr>
								            <th class="text-center">#</th>
								            <th class="text-center">Category Name</th>
								            <th class="text-center">Item Name</th>
								            <th class="text-center">Priority</th>
								            <th class="text-center">Status</th>
								            <th class="text-center">Actions</th>
								        </tr>
								    </thead>
								    <tbody>
									@foreach($data as $item)
									<tr class="item{{$item->id}}">
									    <td>{{$item->id}}</td>
									    <td>{{$item->categories->name}}</td>
									    <td>{{$item->name}}</td>
									    <td>{{$item->sort}}</td>
									    <td>{{$item->status}}</td>
									    <td><a href="{{ route('edititem', ['id' => $item->id]) }}" class="btn btn-success btn-line btn-rect">
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
    $('#itemTable').DataTable();
} );
 </script>
@stop
