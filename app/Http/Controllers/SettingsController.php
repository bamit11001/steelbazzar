<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Categories;
use App\Area;
use App\Services;
use App\Countries;
use App\Plans;
use App\Plans_validity;
use App\Time_template;
use Illuminate\Support\Facades\Auth;
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','','']]);
    }


    public function index()
    {
    	$data = Item::with('categories')->with('item_size')->get();
    	return response()->json([
            'items' => $data, 'status' => 200
        ]);
    }
    public function getCategoryList()
    {
        $categories = Categories::all();
        return response()->json([
            'categories' => $categories, 'status' => 200
        ]);
    }
    public function saveItem(Request $request)
    {
        $sizechips = $request->input('sizechips');
        // print_r($sizechips);die;
    	$validator = \Validator::make($request->all(), [
            'category' => ['required', 'Integer'],
            'item' => ['required', 'string', 'max:50'],
            'sort' => 'required',
            'short_name' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
            
            
            if(Item::where('name', '=' ,$request->input('item'))->where('cat_id', '=' ,$request->input('category'))->exists()){
                return response()->json(['status' => 500,'errors'=>["Item already exists with this category."]]);
            }
        
        $item = new Item();
	    //On left field name in DB and on right field name in Form/view
	    $item->cat_id = $request->input('category');
	    $item->name = $request->input('item');
        $item->status = $request->input('status');
	    $item->shortcode = $request->input('short_name');
	    $item->sort = $request->input('sort');
	    $item->added_by = Auth::user()->id;
        $item->save();
        if($request->has('sizechips')){
            if(count($sizechips)>0){
                $item_size_array = [];
               foreach($sizechips as $sizechip){
                //    $item_size_array[] = ['item_size' =>$sizechip['tag'],
                   $item_size_array[] = ['item_size' =>$sizechip['value'],
                                   'type' =>'size', 
                                   'unit' =>'mm', 
                                   'status' =>$request->input('status'), 
                                   'added_by' =>Auth::user()->id
                               ];
               }
               
               $item->item_size()->createMany($item_size_array);
       }
        }
       
       
         return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    	
        
    }
    public function updateItem(Request $request)
    {
       $validator = \Validator::make($request->all(), [
            'category' => ['required', 'Integer'],
            'item' => ['required', 'string', 'max:50'],
            'sort' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
            
        
        if(Item::where('name', '=' ,$request->input('item'))->whereNotIn('id', [$request->input('item_id')])->where('cat_id', '=' ,$request->input('category'))->exists()){
                return response()->json(['status' => 500,'errors'=>["Item already exists with this category."]]);
            }
       
       $item = Item::find($request->input('item_id'));

        $item->cat_id = $request->input('category');
        $item->name = $request->input('item');
        $item->status = $request->input('status');
        $item->sort = $request->input('sort');
        $item->added_by = Auth::user()->id;

        $item->save();
         return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }


    public function saveCategory(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'category' => ['required', 'string', 'max:50'],
            'sort' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }
           
        if(Categories::where('name', '=' ,$request->input('category'))->exists()){
                return response()->json(['status' => 500,'errors'=>["Category name already exists."]]);
            }
        $category = new Categories();
        //On left field name in DB and on right field name in Form/view
        $category->name = $request->input('category');
        $category->status = $request->input('status');
        $category->sort = $request->input('sort');
        $category->added_by = Auth::user()->id;
        $category->save();
        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }
   

   
    public function updateCategory(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'category' => ['required', 'string', 'max:50'],
            'sort' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }
           
        if(Categories::where('name', '=' ,$request->input('category'))->where('id', '!=' , $request->input('category_id'))->exists()){
                return response()->json(['status' => 500,'errors'=>["Category name already exists."]]);
            }
         $category = Categories::find($request->input('category_id'));
        //On left field name in DB and on right field name in Form/view
        $category->name = $request->input('category');
        $category->status = $request->input('status');
        $category->sort = $request->input('sort');
        $category->added_by = Auth::user()->id;
        $category->save();
        return response()->json(['status' => 200,'success'=>'Record is successfully updated']);
    }




    public function area()
    {
        $areas = Area::all();
        return response()->json([
            'area' => $areas, 'status' => 200
        ]);
    }
   
    public function saveArea(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'city_name' => ['required', 'string', 'max:50'],
            'sort' => 'required',
            'status' => 'required',
            'country' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }
           
        if(Area::where('city_name', '=' ,$request->input('city_name'))->exists()){
                return response()->json(['status' => 500,'errors'=>["City name already exists."]]);
            }
        $area = new Area();
        //On left field name in DB and on right field name in Form/view
        $area->city_name = $request->input('city_name');
        $area->status = $request->input('status');
        $area->short_name = $request->input('short_name');
        $area->sort = $request->input('sort');
        $area->added_by = Auth::user()->id;
        $area->country_id = $request->input('country');
        $area->save();
        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }
   

    
    public function updateArea(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'city_name' => ['required', 'string', 'max:50'],
            'sort' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }
           
        if(Area::where('city_name', '=' ,$request->input('city_name'))->where('id', '!=' , $request->input('area_id'))->exists()){
                return response()->json(['status' => 500,'errors'=>["Area name already exists."]]);
            }
        $area = Area::find($request->input('area_id'));
        //On left field name in DB and on right field name in Form/view
        $area->city_name = $request->input('city_name');
        $area->short_name = $request->input('short_name');
        $area->status = $request->input('status');
        $area->sort = $request->input('sort');
        $area->added_by = Auth::user()->id;
        $area->save();
        return response()->json(['status' => 200,'success'=>'Record is successfully added']);
    }
    public function itemToArea()
    {
        $areas = Area::all();
        $item = $this->getAllItems();
        $services =  Services::with('item')->with('area')->with('area.countries')->get()->where('status','=','1');
        
        return view ( 'setting.service.areaitem', ['services' => $services, 'areas' => $areas, 'item' => $item] );
    }
    public function getcountryitem(Request $request)
    {
       
        $area_available = Area::where("country_id","=",$request->input('country_id'))->get();
        return response()->json(['success'=>'1', 'status' => '200', 'area_available' => $area_available]);
        
    }
    public function getAllItems()
    {
        $items = Item::all();
        return $items;
    }
     public function addItemArea()
    {
       $items = $this->getAllItems();
        $countries_available = Area::with('countries')->get()->groupBy('country_id');
        // return view('setting.service.additemarea', ['countries_available' => $countries_available, 'items' => $items]);
        return response()->json(['success'=>'1', 'status' => '200', 'countries_available' => $countries_available, 'items' => $items]);
    }
     public function saveItemArea(Request $request)
    {
        // print_r($request->all());die;
        $validator = \Validator::make($request->all(), [
            'Country' => ['required', 'numeric', 'max:150'],
            'area' => ['required'],
            'items' => ['required', 'array'],
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }
        if(Services::where('area_id', '=' , $request->input('area'))->exists()){
            // $res=Services::where('area_id',$request->input('area'))->delete();
        }
        $req = $request->all();
       collect($request->input('items'))->each(function ($items) use ($req) {
        
        
            if(!empty($items['id'])){
                $data = [];
                if(isset($items['price']) && $items['price']>0){
                    $data['price'] = $items['price'];
                }
                $data['added_by'] = Auth::user()->id;
                $data['status'] = 0;
                if(isset($items['servicestatus']) && $items['servicestatus']==true){
                    $data['status'] = 1;
                }
                $itemWithSize = Item::with('item_size')->has('item_size')->get()->where('id',  '=' , $items['id']);
                
                if(count($itemWithSize)>0){
                    foreach($itemWithSize as $itemsize){
                   
                    collect($itemsize['item_size'])->each(function ($item_size) use ($req, $items, $data) {
                        $status = isset($items['status'])?1:0;
                        
                        $user = Services::updateOrCreate(['item_id' => $items['id'], 'area_id' => $req['area'],'item_size_id' => $item_size->id],
                        $data);
                    });
                }
                }else{
              
                
                
                // print_r($data);
                $user = Services::updateOrCreate(['item_id' => $items['id'], 'area_id' => $req['area']],
                $data);
                // print_r($user);
                }
                
              
            }
            
        });
        return response()->json(['status' => 200,'success'=>'updated successfully']);
    }

    public function saveItemAreawithoutsize(Request $request)
    {
        
        $validator = \Validator::make($request->all(), [
            'Country' => ['required', 'numeric', 'max:150'],
            'area' => ['required'],
            'items' => ['required', 'array'],
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }
        if(Services::where('area_id', '=' , $request->input('area'))->exists()){
            // $res=Services::where('area_id',$request->input('area'))->delete();
        }
        $req = $request->all();
       collect($request->input('items'))->each(function ($items) use ($req) {
        
        
            if(!empty($items['id'])){
                
                $data = [];
                if(isset($items['price']) && $items['price']>0){
                    $data['price'] = $items['price'];
                }
                $data['added_by'] = Auth::user()->id;
                $data['status'] = 0;
                if(isset($items['servicestatus']) && $items['servicestatus']==true){
                    $data['status'] = 1;
                }
               
                $user = Services::updateOrCreate(['item_id' => $items['id'], 'area_id' => $req['area']],
                $data);
               
                
              
            }
            
        });
        return response()->json(['status' => 200,'success'=>'updated successfully']);
    }

    public function getareaitems(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'area_id' => ['required', 'numeric', 'max:50'],
        ]);

        $itemsSelectedInArea =  Services::where('area_id', '=', $request->input('area_id'))->get();
        $itemsall = $this->getAllItems();
        foreach($itemsSelectedInArea as $selectedServices){
            foreach($itemsall as $key => $itemsingle){
                if($itemsingle->id == $selectedServices->item_id){
                    $itemsall[$key]['servicestatus'] = $selectedServices->status;
                    $itemsall[$key]['price'] = $selectedServices->price;
                    break;
                }
            }
        }
         return response()->json(['success'=>'1', 'status' => '200', 'items' => $itemsall]);
       
    }
    
     public function saveplans(Request $request)
    {
         $validator = \Validator::make($request->all(), [
            'planname' => ['required'],
            'shortname' => ['required']
        ]);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $item = new Plans();
        //On left field name in DB and on right field name in Form/view
        $item->plan_name = $request->input('planname');
        $item->plan_id = '11';
        $item->short_name  = $request->input('shortname');
        $item->sort = $request->input('sort');
        $item->added_by = Auth::user()->id;
        $item->save();
        return response()->json(['status' => 200,'success'=>'Plan created successfully!']);
       
    }
  
     public function saveplansvalidity(Request $request)
    {
         $validator = \Validator::make($request->all(), [
            'validity_name' => ['required'],
            'validity' => ['required','numeric']
        ]);
        if($validator->fails()) {
            // return response()->json(['status' => 200,'success'=>'Plan created successfully!']);
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }

         $item = new Plans_validity();
        //On left field name in DB and on right field name in Form/view
        $item->validity_name = $request->input('validity_name');
        $item->validity = $request->input('validity');
        $item->discount    = $request->input('discount');
        $item->discount_type = $request->input('discount_type');
        $item->max_discount = $request->input('maxdiscount');
        $item->added_by = Auth::user()->id;
        $item->status = $request->input('status');
        $item->save();
        return response()->json(['status' => 200,'success'=>'Plan validity created successfully!']);
        
    }

    
     public function savetimetemplate(Request $request)
    {
         $validator = \Validator::make($request->all(), [
            'timetemplate' => ['required'],
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 500,'errors'=>$validator->errors()->all()]);
        }

        $item = new Time_template();
        $item->time = $request->input('timetemplate');
        $item->added_by = Auth::user()->id;
        $item->status = $request->input('status');
        $item->save();
        return response()->json(['status' => 200,'success'=>'Time created successfully!']);
        // return redirect('plansvalidity')->with('message', 'Plan created successfully!');
    }
     public function userpackage()
    {
        $areas = Area::all();
        $item = $this->getAllItems();
        $services =  Services::with('item')->with('area')->with('area.countries')->get()->where('status','=','1');
        return view ( 'package.userpackage', ['services' => $services, 'areas' => $areas, 'item' => $item] );
    }
    public function getareafromitem(Request $request){
        
        $area =  Services::with('area')->get()->where('item_id','=',$request->input('data'))->groupBy('area_id');
        return response()->json([ 'status' => '200', 'data' => $area]);
    }

    public function cronJob(Request $request){
        
    }
}
