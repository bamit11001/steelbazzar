<?php

namespace App\Http\Controllers;
use App\Categories;
use App\Item;
use App\Services;
use App\Area;
use App\Buy_sell;
use App\Post;
use App\User;
use App\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['updateBuySell','updatePost','getBuySell','getPostData','savePost','registerUser','saveBuySell','login','register','getCategoriesHaveSize','getCategoriesHaventSize','getRatesForSize','getAvailableCountries', 'getItemsByCategory', 'getAreaByItem', 'getRates']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.dashboard');
    }
    public function getCategoriesHaveSize(){
        $categories = Categories::Where('have_sizes' ,'1')->get();
        return response()->json([
            'categories' => $categories, 'status' => 200
        ]);
    }
    public function getCategoriesHaventSize(){
        $categories = Categories::Where('have_sizes' ,'0')->get();
        return response()->json([
            'categories' => $categories, 'status' => 200
        ]);
    }
    public function getRatesForSize(Request $request){
        $country = $request->input('country');
        $category = $request->input('category');
        $item = $request->input('item');
        $area = $request->input('area');
        $brand = $request->input('brand');
        
            $services =  Services::whereHas('area', function($q) use ($country) {
                $q->where('country_id','=', $country);
                
            })->with('price_live')->with('item')->with('item_size')->with('item.item_size')->with('item.brand')->with('area')->with('area.countries')->where('status','=','1');
       
        
        // if($area!=''){
        //     $services->where('area_id','=',$area);
        // }
        $data = $services->get();
        return response()->json([
            'services' => $data, 'status' => 200
        ]);
    }
    public function getAvailableCountries(){
        $countries_available = Area::with('countries')->get()->groupBy('country_id');
        return response()->json([
            'countries' => $countries_available, 'status' => 200
        ]);
       }
       public function getItemsByCategory(Request $request){
        $req = $request->all();
        $category = Categories::where('id', '=' , $req['catid'])->get();
        $items = DB::table('item')
                        ->where('cat_id', '=',$req['catid'])
                        ->where(function ($query) use ($req) {
                            if(isset($req['brandid']) && $req['brandid']!=''){
                                $query->where('brand_id', '=',$req['brandid']);
                            }
                        })
                        ->get();
        if($req['getbrand'] == 1 && $category[0]->have_sizes == '1'){
            $brand = DB::table('brand')
                        ->get();
            $resData = ['items' => $brand, 'status' => 200,'brand' => 1];
        }else{
            $resData = ['items' => $items, 'status' => 200,'brand' => 0];
        }
        return response()->json($resData);
    }
    public function getAreaByItem(Request $request){
      
        $country = $request->input('country_id');
        
            $area  =  Services::whereHas('area', function($q) use ($country) {
                $q->where('country_id','=', $country);
            })->with('area')->get()->where('item_id','=',$request->input('itemid'))->groupBy('area_id');
      
        return response()->json([
            'area' => $area, 'status' => 200
        ]);
    }
    public function getRates(Request $request){
        $country = $request->input('country');
        $category = $request->input('category');
        $item = $request->input('item');
        $area = $request->input('area');
        $brand = $request->input('brand');
        if($brand == 1){
            $services =  Services::whereHas('area', function($q) use ($country) {
                $q->where('country_id','=', $country);
                
            })->with('price_live')->with('item')->with('item_size')->with('item.item_size')->with('item.brand')->with('area')->with('area.countries')->where('status','=','1');
        }else{
            // $data = DB::table('services')
            // ->join('item','services.item_id', '=' ,'item.id')
            // ->join('categories',  'item.cat_id', '=', 'categories.id')
            // ->select('services.*', 'item.*', 'categories.*')
            // ->where('categories.id','=', $category)
            // ->get();
            $services =  Services::whereHas('area', function($q) use ($country) {
                $q->where('country_id','=', $country);
                
            })->with('price_live')->with('item')->with('area')->with('area.countries')->where('status','=','1');
        }
        if($item!=''){
             $services->where('item_id','=',$item);
        }
        if($area!=''){
            $services->where('area_id','=',$area);
        }
        $data = $services->get();
        return response()->json([
            'services' => $data, 'status' => 200
        ]);
    }
    public function saveBuySell(Request $request){
       
        // print_r($sizechips);die;
    	$validator = \Validator::make($request->all(), [
            'item_name' => ['required', 'string', 'max:50']
           
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $post_type = 'buy';
        $poost = $request->input('post_type');
        if(isset($poost) && $poost==true){
            $post_type = 'sell';
        }
        $buySell = new Buy_sell();
	    //On left field name in DB and on right field name in Form/view
	    $buySell->post_type = $post_type;
	    $buySell->item_name = $request->input('item_name');
	    $buySell->weight = $request->input('weight');
	    $buySell->unit = $request->input('unit');
        $buySell->price = $request->input('price');
        $buySell->name = $request->input('name');
        $buySell->contact_no = $request->input('contact_no');
        $buySell->address = $request->input('address');
        $buySell->country_id = $request->input('country_id');
        $buySell->state_id = $request->input('state_id');
        $buySell->city_id = $request->input('city_id');
        $buySell->amount = $request->input('amount');
        

        $buySell->status = 1;
	    $buySell->added_by = isset(Auth::user()->id)?Auth::user()->id:0;
        $buySell->save();

        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    	
    }
    public function getBuySell(Request $request){
        $buy_sell = Buy_sell::all();
        return response()->json(['data' => $buy_sell, 'status' => 200]);
       
    }
    public function getSell(Request $request){
        $buy_sell = Buy_sell::where('post_type','=', 'sell')->get();
        return response()->json(['data' => $buy_sell, 'status' => 200]);
       
    }
    public function getBuy(Request $request){
        $buy_sell = Buy_sell::where('post_type','=', 'buy')->get();
        return response()->json(['data' => $buy_sell, 'status' => 200]);
       
    }
    public function getTender(Request $request){
        $tender = Tender::all();
        return response()->json(['data' => $tender, 'status' => 200]);
       
    }

    public function savePost(Request $request){
        $filename = '';
        $post_type = 'news';
            $poost = $request->input('post_type');
            if(isset($poost)){
                $post_type = $poost;
            }
        if($request->hasFile('post'))
            {
                $allowedfileExtension=['jpg','jpeg','png'];
                $file = $request->file('post');
                
                $fileoriginname = $file->getClientOriginalName();
                
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                // dd($extension);
                if($check)
                {
                    $photo =  $request->post;
                    $filename = $photo->store($post_type);
                    // print_r($filename);die;
                }
                else
                {
            
                }
          
            }
            
            $post = new Post();
            $post->post_type = $post_type;
            $post->title = $request->input('title');
            $post->item_id = $request->input('item_id');
            $post->categories_id = $request->input('categories_id');
            $post->description = $request->input('description');
            $post->image = $filename;
            $post->name = $request->input('name');
            // $post->contact = $request->input('contact');
            $post->status = 1;
            $post->added_by = isset(Auth::user()->id)?Auth::user()->id:0;
            if(!$post->save()){
                return response()->json(['status' => 500,'success'=>'Something went wrong.']);
            }else{
                return response()->json(['status' => 200,'success'=>'Record is successfully added.']);
            }
            
    }

    public function registerUser(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', ],
            'address' => ['required', 'string', ],
            'city' => ['required', 'string', ],
            'state' => ['required', 'string', ],
            'group' => ['required', 'string', ],
        ]);
         if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
       $user = [
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')),
                'country' => request('country'),
                'username' => request('username'),
                'mobile' => request('mobile'),
                'address' => request('address'),
                'city' => request('city'),
                'state' => request('state'),
                'refno' => request('refno')?request('refno'):'',
                'group' => request('group'),
       ];
        if(User::create($user)){
          return response()->json(['status' => 200,'success'=>'Registered successfully.'], 200);
        }else{
             return response()->json(['error' => 'error registering'], 401);
        }
       

        
    }

    public function listUser(){
       $user =  User::where('role','=', '0')->get();
       return response()->json([ 'data' => $user, 'status' => 200], 200);
    }
        public function dsfasdfa(){
        // $this->validate($request, [
        //     'name' => 'required',
        //     'photos'=>'required',
        //     ]);
            if($request->hasFile('post'))
            {
                $allowedfileExtension=['pdf','jpg','png','docx'];
                $file = $request->file('post');
                
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                //dd($check);
                if($check)
                {
                    $photo =  $request->post;
                    $filename = $photo->store('post');
                }
                else
                {
            
                }
          
            }
    }
    public function getCategories(){
        $categories = Categories::all();
        return response()->json([
            'categories' => $categories, 'status' => 200
        ]);
    }
    public function getPostData(Request $request){
        // print_r("adsfadsfads");
        $req = $request->all();
        $post = DB::table('post')
                        ->where('post_type', '=', $req['post_type'])
                        ->get();
        $resData = ['post' => $post, 'status' => 200];
        return response()->json($resData);
    }
    public function updatePost(Request $request)
    {
    //    $validator = \Validator::make($request->all(), [
    //         'category' => ['required', 'Integer'],
    //         'item' => ['required', 'string', 'max:50'],
    //         'sort' => 'required',
    //         'status' => 'required',
    //     ]);
        
    //     if ($validator->fails())
    //     {
    //         return response()->json(['errors'=>$validator->errors()->all()]);
    //     }
            
        
    //     if(Item::where('name', '=' ,$request->input('item'))->whereNotIn('id', [$request->input('item_id')])->where('cat_id', '=' ,$request->input('category'))->exists()){
    //             return response()->json(['status' => 500,'errors'=>["Item already exists with this category."]]);
    //         }
       
    //    $item = Item::find($request->input('item_id'));

    //     $item->cat_id = $request->input('category');
    //     $item->name = $request->input('item');
    //     $item->status = $request->input('status');
    //     $item->sort = $request->input('sort');
    //     $item->added_by = Auth::user()->id;

        
        $post = Post::find($request->input('post_id'));
        $post->title = $request->input('title');
        $post->item_id = $request->input('item_id');
        $post->categories_id = $request->input('categories_id');
        $post->description = $request->input('description');
        // $post->image = $filename;
        // $post->name = $request->input('name');
        $post->save();

         return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }



    public function updateBuySell(Request $request)
    {
        $post = Buy_sell::find($request->input('post_id'));
        $post->post_type = $request->input('post_type');
        $post->address = $request->input('address');
        $post->amount = $request->input('amount');
        $post->contact_no = $request->input('contact_no');
        $post->country_id = $request->input('country');
        $post->item_name = $request->input('item_name');
        $post->name = $request->input('name');
        $post->price = $request->input('price');
        $post->state_id = $request->input('state');
        $post->unit = $request->input('unit');
        $post->weight = $request->input('weight');
        $post->city_id = $request->input('city');
        $post->save();
        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }

    public function tenderUpdate(Request $request)
    {
        $post = Tender::find($request->input('post_id'));
        $post->post_type = $request->input('post_type');
        $post->address = $request->input('address');
        $post->amount = $request->input('amount');
        $post->contact_no = $request->input('contact_no');
        $post->country_id = $request->input('country');
        $post->item_name = $request->input('item_name');
        $post->name = $request->input('name');
        $post->price = $request->input('price');
        $post->state_id = $request->input('state');
        $post->unit = $request->input('unit');
        $post->weight = $request->input('weight');
        $post->city_id = $request->input('city');
        $post->save();
        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }

    public function tenderSave(Request $request){
        $req = $request->all();
        $startdate =  gmdate('Y-m-d',strtotime('+1 day', strtotime($req['sdate']) ));
        $enddate =  gmdate('Y-m-d',strtotime('+59 minutes',strtotime('+23 hours',strtotime('+1 day', strtotime($req['edate']) ))));
        // print_r($sizechips);die;
    	$validator = \Validator::make($request->all(), [
            'item_name' => ['required', 'string', 'max:50']
           
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $post_type = 'buy';
        $poost = $request->input('post_type');
        if(isset($poost) && $poost==true){
            $post_type = 'sell';
        }
        $buySell = new Tender();
	    //On left field name in DB and on right field name in Form/view
	    $buySell->post_type = $post_type;
	    $buySell->item_name = $request->input('item_name');
	    $buySell->weight = $request->input('weight');
	    $buySell->unit = $request->input('unit');
        $buySell->price = $request->input('price');
        $buySell->name = $request->input('name');
        $buySell->contact_no = $request->input('contact_no');
        $buySell->address = $request->input('address');
        $buySell->country_id = $request->input('country_id');
        $buySell->state_id = $request->input('state_id');
        $buySell->city_id = $request->input('city_id');
        $buySell->amount = $request->input('amount');
        

        $buySell->status = 1;
	    $buySell->added_by = isset(Auth::user()->id)?Auth::user()->id:0;
        $buySell->save();

        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    	
  
    }
    public function getUserValidity(){
        $user_id = isset(Auth::user()->id)?Auth::user()->id:1;
        $post = DB::table('user_package')
                        ->where('user_id', '=', $user_id)
                        ->latest('end_date')
                        ->limit(1)
                        ->get();
        $user = DB::table('users')
                        ->where('id', '=', $user_id)
                        // ->latest('end_date')
                        ->limit(1)
                        ->get();
        return response()->json(['data' => $post,'user' => $user, 'status' => 200,'success'=>'Record is successfully added']);
    }
    public function getUserHistory(){
        $user_id = isset(Auth::user()->id)?Auth::user()->id:1;
        $post = DB::table('user_package')
                        ->where('user_id', '=', $user_id)
                        // ->join('user_id', '=', $user_id)
                        ->latest('end_date')
                        ->get();
        $user = DB::table('users')
                        ->where('id', '=', $user_id)
                        // ->latest('end_date')
                        ->limit(1)
                        ->get();
        return response()->json(['data' => $post,'user' => $user, 'status' => 200,'success'=>'Record is successfully added']);
    }
}


