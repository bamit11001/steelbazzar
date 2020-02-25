<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Categories;
use App\Area;
use App\Services;
use App\Countries;
use App\Plans;
use App\Plans_validity;
use App\Time_template;
use Auth;
use Illuminate\Support\Facades\Redirect;
class SettingController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data = Item::with('categories')->get();
    	return view ( 'setting.item' )->withData ( $data );
    }
    public function addItem()
    {
    	
    	$categories = Categories::all();
    	return view ( 'setting.additem' , ['categories' => $categories]);
        
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
                return response()->json(['errors'=>["Item already exists with this category."]]);
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
        $item_size_array = [];
        foreach($sizechips as $sizechip){
            $item_size_array[] = ['item_size' =>$sizechip['tag'],
                            'type' =>'size', 
                            'unit' =>'mm', 
                            'status' =>$request->input('status'), 
                            'added_by' =>Auth::user()->id
                        ];
        }
        
        $item->item_size()->createMany($item_size_array);
         return response()->json(['success'=>'Record is successfully added']);
    	
        
    }

     public function editItem($id)
    {
        $item = Item::where("id",'=',$id)->get();
        $categories = Categories::all();
        return view ( 'setting.edit_item',["item" => $item, 'categories' => $categories]);
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
            
            
            if(Item::where('name', '=' ,$request->input('item'))->where('cat_id', '=' ,$request->input('category'))->exists()){
                return response()->json(['errors'=>["Item already exists with this category."]]);
            }
       
       $item = Item::find($request->input('item_id'));

        $item->cat_id = $request->input('category');
        $item->name = $request->input('item');
        $item->status = $request->input('status');
        $item->sort = $request->input('sort');
        $item->added_by = Auth::user()->id;

        $item->save();
         return response()->json(['success'=>'Record is successfully added']);
    }


    public function category()
    {
       
        $categories = Categories::all();
         return view ( 'setting.category' )->withData ( $categories );
        
    }
    public function addCategory()
    {
        return view ( 'setting.addcategory');
        
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
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
           
        if(Categories::where('name', '=' ,$request->input('category'))->exists()){
                return response()->json(['errors'=>["Category name already exists."]]);
            }
        $category = new Categories();
        //On left field name in DB and on right field name in Form/view
        $category->name = $request->input('category');
        $category->status = $request->input('status');
        $category->sort = $request->input('sort');
        $category->added_by = Auth::user()->id;
        $category->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
   

    public function editCategory($id)
    {
        $categories = Categories::where("id",'=',$id)->get();
        return view ( 'setting.edit_category',[ 'categories' => $categories]);
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
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
           
        if(Categories::where('name', '=' ,$request->input('category'))->exists()){
                return response()->json(['errors'=>["Category name already exists."]]);
            }
         $category = Categories::find($request->input('category_id'));
        //On left field name in DB and on right field name in Form/view
        $category->name = $request->input('category');
        $category->status = $request->input('status');
        $category->sort = $request->input('sort');
        $category->added_by = Auth::user()->id;
        $category->save();
        return response()->json(['success'=>'Record is successfully added']);
    }




    public function area()
    {
        $areas = Area::all();
        return view ( 'setting.area.area', ['areas' => $areas] );
    }
    public function addArea()
    {
        $countries = Countries::all();
        return view ( 'setting.area.addarea', ['countries' => $countries]);
        
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
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
           
        if(Area::where('city_name', '=' ,$request->input('city_name'))->exists()){
                return response()->json(['errors'=>["City name already exists."]]);
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
        return response()->json(['success'=>'Record is successfully added']);
    }
   

    public function editArea($id)
    {
        $area = Area::where("id",'=',$id)->get();
       
        return view ( 'setting.area.edit_area',[ 'area' => $area]);
       
        
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
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
           
        if(Area::where('city_name', '=' ,$request->input('city_name'))->exists()){
                return response()->json(['errors'=>["City name already exists."]]);
            }
        $area = Area::find($request->input('area_id'));
        //On left field name in DB and on right field name in Form/view
        $area->city_name = $request->input('city_name');
        $area->status = $request->input('status');
        $area->sort = $request->input('sort');
        $area->added_by = Auth::user()->id;
        $area->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function itemToArea()
    {
        $areas = Area::all();
        $item = $this->getAllItems();
        $services =  Services::with('item')->with('area')->with('area.countries')->get()->where('status','=','1');
        // print_r($services);die;
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
        return view('setting.service.additemarea', ['countries_available' => $countries_available, 'items' => $items]);
        
    }
     public function saveItemArea(Request $request)
    {
        //  print_r($request->all());die;
        $validator = \Validator::make($request->all(), [
            'Country' => ['required', 'numeric', 'max:150'],
            'area' => ['required'],
            'items' => ['required', 'array'],
        ]);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        if(Services::where('area_id', '=' , $request->input('area'))->exists()){
            // $res=Services::where('area_id',$request->input('area'))->delete();
        }
        $req = $request->all();
       collect($request->input('items'))->each(function ($items) use ($req) {
        
        
            if(!empty($items['id'])){
                $itemWithSize = Item::with('item_size')->has('item_size')->get()->where('id',  '=' , $items['id']);
                
                if(count($itemWithSize)>0){
                    foreach($itemWithSize as $itemsize){
                   
                    collect($itemsize['item_size'])->each(function ($item_size) use ($req, $items) {
                        $status = isset($items['status'])?1:0;
                        echo($items['id']."====".  $req['area'] ."=====". $item_size['id']);
                        $user = Services::updateOrCreate(['item_id' => $items['id'], 'area_id' => $req['area'],'item_size_id' => $item_size->id],
                            ['price' => $items['price'], 'status' => $status , 'added_by' => Auth::user()->id]);
                    });
                }
                }else{
                $status = isset($items['status'])?1:0;
                $user = Services::updateOrCreate(['item_id' => $items['id'], 'area_id' => $req['area']],
                            ['price' => $items['price'], 'status' => $status , 'added_by' => Auth::user()->id]);
                }
                
              
            }
            
        });
       return redirect('additem_area')->with('status', 'Profile updated!');
        
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
    //plans page
     public function plans()
    {
        return view('setting.plan.plans', ['tab' => 'plan']);
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
        $item->short_name    = $request->input('shortname');
        $item->sort = $request->input('sort');
        $item->added_by = Auth::user()->id;
        $item->save();
        return redirect('plans')->with('message', 'Plan created successfully!');
    }
    public function plansvalidity()
    {
        return view('setting.plan.plans', ['tab' => 'planvalidity']);
    }
     public function saveplansvalidity(Request $request)
    {
         $validator = \Validator::make($request->all(), [
            'validity_name' => ['required'],
            'validity' => ['required','numeric']
        ]);
        if($validator->fails()) {
            return redirect('plansvalidity')->withErrors($validator);
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
        return redirect('plansvalidity')->with('message', 'Plan created successfully!');
    }

    public function timetemplate()
    {
        return view('setting.plan.plans', ['tab' => 'timetemplate']);
    }
     public function savetimetemplate(Request $request)
    {
         $validator = \Validator::make($request->all(), [
            'timetemplate' => ['required'],
        ]);
        if($validator->fails()) {
            return redirect('timetemplate')->withErrors($validator);
        }

        $item = new Time_template();
        $item->time = $request->input('timetemplate');
        $item->added_by = Auth::user()->id;
        $item->status = $request->input('status');
        $item->save();
        return redirect('plansvalidity')->with('message', 'Plan created successfully!');
    }
     public function userpackage()
    {
        $areas = Area::all();
        $item = $this->getAllItems();
        $services =  Services::with('item')->with('area')->with('area.countries')->get()->where('status','=','1');
        // print_r($services);die;
        return view ( 'package.userpackage', ['services' => $services, 'areas' => $areas, 'item' => $item] );
    }
}
