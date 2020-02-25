<?php


namespace App\Http\Controllers;
use App\user_group;
use App\User;
use App\Countries;
use App\Area;
use App\Categories;
use App\Item;
use App\Services;
use App\Price_live;
use App\Price_live_history;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getPriceHistory','getItemsByCategoryAll','getCategories','getStates','getCities','login','register', 'getContries']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
       $user = [
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')),
       ];
        if(User::create($user)){
            $credentials = request(['email', 'password']);
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        }else{
             return response()->json(['error' => 'error registering'], 401);
        }
       
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function getContries(){
        $countries = Countries::all();
        return response()->json([
                    'countries' => $countries, 'status' => 200
                ]);

    }
    public function getStates(Request $request){
       $states =  DB::table('states')->where('country_id',$request->input('country'))->get();
        return response()->json([
                    'states' => $states, 'status' => 200
                ]);

    }
    public function getCities(Request $request){
       $cities =  DB::table('cities')->where('state_id',$request->input('state'))->get();
        return response()->json([
                    'cities' => $cities, 'status' => 200
                ]);

    }

     public function registerUser(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password' => ['required',  'min:8', 'confirmed'],
          
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
                'group_name' => request('group'),
       ];
        if(User::create($user)){
          return response()->json(['success' => '1'], 200);
        }else{
             return response()->json(['error' => 'error registering'], 401);
        }
       

        
    }


    public function getAvailableCountries(){
        $countries_available = Area::with('countries')->get()->groupBy('country_id');
        return response()->json([
            'countries' => $countries_available, 'status' => 200
        ]);
       }

    public function getCategories(){
        $categories = Categories::all();
        return response()->json([
            'categories' => $categories, 'status' => 200
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
        if(isset($req['getbrand']) && $req['getbrand'] == 1 && $category[0]->have_sizes == '1'){
            $brand = DB::table('brand')
                        ->get();
            $resData = ['items' => $brand, 'status' => 200,'brand' => 1];
        }else{
            $resData = ['items' => $items, 'status' => 200,'brand' => 0];
        }
        return response()->json($resData);
    }
    public function getItemsByCategoryAll(Request $request){
        $req = $request->all();
       
        $items = DB::table('item')
                        ->where('cat_id', '=',$req['catid'])
                        ->get();
        $resData = ['items' => $items, 'status' => 200];
        return response()->json($resData);
    }
    public function  getUser(){
        $user = DB::table('users')
                        ->where('role', '=',0)
                        ->get();
        $resData = ['data' => $user, 'status' => 200];
        return response()->json($resData);
    }
    public function getAreaByItem(Request $request){
        // $area = DB::table('services')
        //                 ->where('item_id', '=',$request->input('itemid'))
        //                 ->get();
        $country = $request->input('country_id');
        
            $area  =  Services::whereHas('area', function($q) use ($country) {
                if(isset($country)){
                    $q->where('country_id','=', $country);
                }
                
            })->with('area')->get()->where('item_id','=',$request->input('itemid'))->groupBy('area_id');
      
            // $area  =  Services::whereHas('area', function($q) use ($country) {
            //     $q->where('country_id','=', $country);
            // })->with('area')->get()->where('item_id','=',$request->input('itemid'));
        
        
        

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
                
            })->with('price_live')->with('item')->with('item_size')->with('item.item_size')->with('item.brand')->with('area')->with('area.countries')->where('status','=','1')->where('item_id','=',$item);
        }else{
            $services =  Services::whereHas('area', function($q) use ($country) {
                $q->where('country_id','=', $country);
                
            })->with('price_live')->with('item')->with('area')->with('area.countries')->where('status','=','1')->where('item_id','=',$item);
        }
        
        if($area!=''){
            $services->where('area_id','=',$area);
        }
        $data = $services->get();
        return response()->json([
            'services' => $data, 'status' => 200
        ]);
    }
    public function updateRates(Request $request){
        $req = $request->all();
        collect($request->input('prices'))->each(function ($price) use ($req) {
            $where = [
                        'item_id' => $price['item_id'],
                        'area_id' => $price['area_id']
                    ];
         $dataToUpdate = [
                        'region_id' => $price['country_id'],
                        'services_id' => $price['service_id'],
                        'price' => $price['price'],
                        'gst' => $price['gst'],
                        'for_ex' => $price['for_ex'],
                        'delivery' => $price['delivery'],
                        'size' => $price['size'],
                        'grade' => $price['grade'],
                        'unit' => $price['unit'],
                        'sentiment' => $price['sentiment'],
                    ];
                    if($price['price']!=$price['oldPrice']){
                        $dataToUpdate['price_updated_at'] = DB::raw('NOW()');
                    }
                    $user = Price_live::updateOrCreate($where , $dataToUpdate  );
                    if($price['price']!=$price['oldPrice']){
                        $price_live_history = new Price_live_history();
                        $price_live_history->item_id = $price['item_id'];
                        $price_live_history->area_id = $price['area_id'];
                        $price_live_history->region_id    = $price['country_id'];
                        $price_live_history->services_id = $price['service_id'];
                        $price_live_history->price = $price['price'];
                        $price_live_history->gst = $price['gst'];
                        $price_live_history->for_ex = $price['for_ex'];
                        $price_live_history->delivery = $price['delivery'];
                        $price_live_history->size = $price['size'];
                        $price_live_history->grade = $price['grade'];
                        $price_live_history->unit = $price['unit'];
                        $price_live_history->sentiment = $price['sentiment'];
                        $price_live_history->save();
                    }
        
         });

         return response()->json([
            'msg' => "Rates updated sucessfully",'status' => 200
        ]);
    }

    public function updateSizeRates(Request $request){
        $req = $request->all();
        $prices = [];
        foreach($req['prices'] as $priceSize){
            foreach($priceSize['item_size'] as $item_size){
                $data['item_id'] = $item_size['item_id'];
                $data['area_id'] = $item_size['area_id'];
                $data['country_id'] = $item_size['country_id'];
                $data['service_id'] = $item_size['service_id'];
                $data['price'] = $item_size['price'];
                $data['oldPrice'] = $item_size['oldPrice'];
                $data['item_size_id'] = $item_size['item_size_id'];
                $prices[] = $data;
            }
        }
        // print_r($prices);die;
        collect($prices)->each(function ($price) use ($req) {
            $where = [
                        'item_id' => $price['item_id'],
                        'area_id' => $price['area_id'],
                        'item_size_id' => $price['item_size_id'],
                    ];
         $dataToUpdate = [
                        'region_id' => $price['country_id'],
                        'services_id' => $price['service_id'],
                        'price' => $price['price'],
                    ];
                    if($price['price']!=$price['oldPrice']){
                        $dataToUpdate['price_updated_at'] = DB::raw('NOW()');
                    }
                    $user = Price_live::updateOrCreate($where , $dataToUpdate  );
                    // if($price['price']!=$price['oldPrice']){
                    //     $price_live_history = new Price_live_history();
                    //     $price_live_history->item_id = $price['item_id'];
                    //     $price_live_history->area_id = $price['area_id'];
                    //     $price_live_history->region_id    = $price['country_id'];
                    //     $price_live_history->services_id = $price['service_id'];
                    //     $price_live_history->price = $price['price'];
                    //     $price_live_history->save();
                    // }
        
         });
         return response()->json([
            'msg' => "Rates updated sucessfully",'status' => 200
        ]);
    }
    public function getPriceHistory(Request $request){
        $req = $request->all();
       $startdate =  gmdate('Y-m-d',strtotime('+1 day', strtotime($req['startdate']) ));
       $enddate =  gmdate('Y-m-d',strtotime('+59 minutes',strtotime('+23 hours',strtotime('+1 day', strtotime($req['enddate']) ))));
    //    $enddate =  gmdate('Y-m-d', strtotime($req['enddate']));
        $price_live_history = DB::table('price_live_history')
                        ->leftJoin('item', 'price_live_history.item_id', '=', 'item.id')
                        ->where('item_id', '=',$req['item'])
                        ->where('area_id', '=',$req['area'])
                        ->where('price_live_history.created_at', '>=',$startdate)
                        ->where('price_live_history.created_at', '<=',$enddate)
                        ->select('price_live_history.*', 'item.name')
                        ->orderBy('price_live_history.created_at', 'asc')
                        ->get();
        $price_live_history11 = DB::table('price_live_history')
                        ->leftJoin('item', 'price_live_history.item_id', '=', 'item.id')
                        ->where('item_id', '=',$req['item'])
                        ->where('area_id', '=',$req['area'])
                        ->where('price_live_history.created_at', '<=',$startdate)
                        // ->where('price_live_history.created_at', '<=',$enddate)
                        ->select('price_live_history.*', 'item.name')
                        ->orderBy('price_live_history.created_at', 'desc')
                        ->limit(1)
                        ->get();
                         $olsprice = '';
                        if(count($price_live_history11) > 0){
                            $olsprice = $price_live_history11[0]->price;
                        }
       
        foreach($price_live_history as $k=>$data){
            if($olsprice != ''){
                $price_live_history[$k]->change = $price_live_history[$k]->price - $olsprice;
            }else{
                $price_live_history[$k]->change = 0;
            }
            // $price_live_history[$k]->change = $price_live_history[$k]->price - $olsprice;
            $olsprice = $price_live_history[$k]->price;
            $date = explode(' ', $price_live_history[$k]->created_at);
            $price_live_history[$k]->dinaak = $date[0];
            $price_live_history[$k]->samay = $date[1];
        }
        $resData = ['data' => $price_live_history,   'status' => 200];
        return response()->json($resData);
    }

    public function todayHistoryPrice(Request $request){
        $todayHistory = Price_live_history::where('region_id',$request->input('country'))
        ->where("item_id",$request->input('item'))
        ->get();
        $resData = ['data' => $todayHistory,   'status' => 200];
        return response()->json($resData);
    }
    public function createGroup(Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'owner' => ['required', 'numeric']
        ]);
         if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $price_live_history = new user_group();
      
        $price_live_history->name = $request->input('name');
        $price_live_history->admin = $request->input('owner');
        // $price_live_history->sentiment = $price['sentiment'];
       if(!$price_live_history->save()){
        $resData = ['message' => 'Something went wrong.',   'status' => 500];
        return response()->json($resData);
       }

        $resData = ['data' => $price_live_history,   'status' => 200];
        return response()->json($resData);
    }
  public function getGroups() {
    $data = user_group::with('User')->with('User.countries')->get();
    $resData = ['data' => $data,   'status' => 200];
    return response()->json($resData);
  }
  public function addMembers(Request $request){
    $validator = \Validator::make($request->all(), [
        'id' => ['required'],
        'members' => ['required']
    ]);
     if ($validator->fails())
    {
        return response()->json(['errors'=>$validator->errors()->all()]);
    }
    $iddd = $request->input('id');
    $members = $request->input('members');
    $strmember =  implode(",", array_column($members, "item_id"));
    
//    print_r($members);die;
    $price_live_history = user_group::find($iddd['id']);
  
    $price_live_history->members = $strmember;
   
   if(!$price_live_history->save()){
    $resData = ['message' => 'Something went wrong.',   'status' => 500];
    return response()->json($resData);
   }

    $resData = ['data' => $price_live_history,   'status' => 200];
    return response()->json($resData);
  }
  
  public function deleteGroup(Request $request){
    $iddd = $request->input('id');
    $price_live_history = user_group::find($iddd);
    $price_live_history->delete();
   if($price_live_history->trashed()){
    $resData = ['data' => $price_live_history,   'status' => 200];
    return response()->json($resData);
   }
   $resData = ['message' => 'Something went wrong.',   'status' => 500];
   return response()->json($resData);
  }
}