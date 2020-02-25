@extends('layouts.default')
 
@section('content')
 
    <h2>Register</h2>
    <form method="POST" action="/register">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
 
        <div class="form-group">
            <label for="mobile">Mobile:</label>
            <input type="text" class="form-control" id="mobile" name="mobile" autocomplete="off">
        </div>
 
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="off">
        </div>

         <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
           <select name="country" id="country" class="materialSelect">
            <option value="">select country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
           </select>
        </div>

        <div class="form-group" >
            <label for="state">State:</label>
           <select name="state" id="state" class="materialSelect">
                <option value="">select state</option>
           </select>
        </div>

        <div class="form-group">
            <label for="city">Country:</label>
           <select name="city" id="city" class="materialSelect">
                <option value="">select city</option>
           </select>
        </div>
 
        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
        </div>
        
    </form>
    <script type="text/javascript">

        $('.materialSelect').material_select();

        // setup listener for custom event to re-initialize on change
        $('.materialSelect').on('contentChanged', function() {
        $(this).material_select();
        });

    $('#country').change(function(){
    var countryID = $(this).val();
    if(countryID){
        $.ajax({
           type:"GET",
           url:"{{url('get-state-list')}}?country_id="+countryID,
           success:function(res){               
            if(res){
                $("#state").empty();
                $("#state").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#state").append('<option value="'+key+'">'+value+'</option>');
                });
                $("#state").trigger('contentChanged');
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#state").empty();
        $("#city").empty();
    }      
   });
    $('#state').on('change',function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
           type:"GET",
           url:"{{url('get-city-list')}}?state_id="+stateID,
           success:function(res){               
            if(res){
                $("#city").empty();
                $("#city").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#city").append('<option value="'+key+'">'+value+'</option>');
                });
                $("#city").trigger('contentChanged');
            }else{
               $("#city").empty();
            }
           }
        });
    }else{
        $("#city").empty();
    }
        
   });






        // $(document).ready(function(){
           // var elem =  $( "#country" )[ 0 ];
           //  var instance = M.FormSelect.getInstance(elem);
           // document.addEventListener('DOMContentLoaded', function() {
           //      var elems = document.querySelectorAll('#country');
           //      var instances = M.FormSelect.init(elems, options);
           //      var instance = M.FormSelect.getInstance(elems);

           //      console.log(elems);
           //    });

           // jQuery Method Calls
           //  You can still use the old jQuery plugin method calls.
           //  But you won't be able to access instance properties.

            // $('select').formSelect('methodName');
            // $('select').formSelect('methodName', paramName);
        // })
        
          
    </script>
 
@endsection