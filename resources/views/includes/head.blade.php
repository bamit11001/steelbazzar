<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="Cypress">
 <meta name="_token" content="{{csrf_token()}}" />
<title>Admin</title>

        <!-- Styles -->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" /> -->
        <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/materialPreloader.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/alpha.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />



<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

        <script src="{{ asset('js/jquery-2.2.0.min.js')}}"></script>

        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
        <script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
        
        <script src="{{ asset('js/materialize.min.js')}}"></script>
        <script src="{{ asset('js/materialPreloader.min.js')}}"></script>
        <script src="{{ asset('js/jquery.blockui.js')}}"></script>
        <script src="{{ asset('js/alpha.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
        <!-- <script src="{{ asset('js/form_elements.js')}}"></script> -->
        <script src="{{ asset('js/datatables/jquery.dataTables.min.js')}}"></script>


  <style>


.error {color: #FF0000;}

form label {
  display: inline-block;
  /*width: 100px;*/
}
 
form div {
  margin-bottom: 10px;
}
 
.error {
  color: red;
  margin-left: 5px;
}
 
label.error {
  display: inline;
}
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>