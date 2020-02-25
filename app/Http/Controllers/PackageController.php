<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Time_template;
use App\Plans;
use App\Plans_validity;
use App\User_package;
use App\Templates;
use App\Template_services;
use App\User_package_services;
use App\Contact;
use App\Comments;
use App\logistics;
use App\Services;
use Carbon\Carbon;
class PackageController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getPlanValidity','getTimeTemplateAndPlan','getPlans','getTimeTemplate']]);
    }
    public function TimeTemplate(){
        $Time_template = Time_template::all();
        return $Time_template;
       }
    public function Plans(){
        $Plans = Plans::all();
        return $Plans;
    }
    public function getTimeTemplateAndPlan(){
        $Plans = $this->Plans();
        $Time_template = $this->TimeTemplate();
        return response()->json([
            'data' => [ 'plan'  => $Plans, 'time' => $Time_template ], 'status' => 200
        ]);
    }
    public function getPlanValidity(){
        $Plans = Plans_validity::all();
        return response()->json([
            'data' => [ 'planvalidity'  => $Plans], 'status' => 200
        ]);
    }
    public function checkout(Request $request){
      
            // echo $mytime->toDateTimeString();die;
        $validator = \Validator::make($request->all(), [
            'data' => ['required', 'array'],
            // 'plan' => ['required', 'array'],
            // 'producttotal' => ['required', 'numeric'],
            // 'time' => ['required', 'json'],
            'total' => ['required', 'numeric'],
            // 'totalwithval' => ['required', 'numeric'],
            'validity' => ['required', 'numeric'],
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $mytime = Carbon::now();
        $start = $mytime->toDateTimeString();
       
        $validity = Plans_validity::where("id","=",$request->input('validity'))->get();
        if($validity[0]->validity == 12){
            $end = $mytime->addYear()->toDateTimeString();
        }else{
            $end = $mytime->addMonths($validity[0]->validity)->toDateTimeString();
        }
        $req = $request->all();
        $data = [];
        $collection = collect($request->input('data'));
        $collection->each(function ($packs) use ($req, $start, $end, $data) {
           
            $item = new User_package();
            $item->user_id = Auth::user()->id;
            $item->plan_validity_id = $req['validity'];
            $item->start_date = $start;
            $item->end_date = $end;
            $item->save();
            
            foreach($packs['cart'] as $service){
                $services = Services::where("item_id","=",$service['item_id'])->where("area_id","=",$service['area_id'])->get();
               if(count($services)>0){
                foreach($services as $keyy=>$val){
                    $User_package_services = new User_package_services();
                    $User_package_services->user_package_id = $item->id;
                    $User_package_services->services_id = $val['id'];
                    $User_package_services->save();
               }
            }
               
                
            }
            
           
        });
        return response()->json([
            'data' => [ 'planvalidity'  =>$data], 'status' => 200
        ]);
    }

    public function addTemplate(Request $request){
      
        // echo $mytime->toDateTimeString();die;
    $validator = \Validator::make($request->all(), [
        'data' => ['required', 'array'],
        'total' => ['required', 'numeric'],
        'validity' => ['required', 'numeric'],
    ]);
    
    if ($validator->fails())
    {
        return response()->json(['errors'=>$validator->errors()->all()]);
    }
    $mytime = Carbon::now();
    $start = $mytime->toDateTimeString();
    $end = $mytime->toDateTimeString();
  
    $req = $request->all();
    $data = [];
    $collection = collect($request->input('data'));
    $collection->each(function ($packs) use ($req, $start, $end, $data) {
        $item = new Templates();
        $item->name = $packs['templatename'];
        $item->price = $packs['producttotal'];
        $item->start_date = $start;
        $item->end_date = $end;
        $item->save();
        foreach($packs['cart'] as $service){
            $services = Services::where("item_id","=",$service['item_id'])->where("area_id","=",$service['area_id'])->get();
           if(count($services)>0){
            foreach($services as $keyy=>$val){

        $User_package_services = new Template_services();
        $User_package_services->templates_id = $item->id;
        $User_package_services->services_id = $val['id'];
        $User_package_services->save();
            }
        }
    }
    });
    return response()->json([
        'data' => [ 'planvalidity'  => $data], 'status' => 200
    ]);
}
public function getTemplates(){
    // $data = Templates::with('Template_services')->with('Template_services.services')->get();
    $dataaa = DB::table('templates')
            ->join('template_services', 'templates.id', '=', 'template_services.templates_id')
            ->join('services', 'services.id', '=', 'template_services.services_id')
            ->join('area', 'area.id', '=', 'services.area_id')
            ->join('item', 'item.id', '=', 'services.item_id')
            ->select('templates.*',  'template_services.*', 'services.area_id','services.item_id', 'area.city_name', 'item.name as item_name')
            ->get();
            $collection = collect($dataaa);
            $data = $collection->groupBy('templates_id');
            $data = $data->toArray();
    return response()->json([
        'data' => $data, 'status' => 200
    ]);
}
public function changeStatus(Request $request){

    $validator = \Validator::make($request->all(), [
        'status' => ['required', 'numeric'],
        'template' => ['required', 'numeric'],
    ]);
    
    if ($validator->fails())
    {
        return response()->json(['errors'=>$validator->errors()->all()]);
    }

    $flight = Templates::find($request->input('template'));

    $flight->status = $request->input('status');

    $flight->save();
    if($flight){
        return response()->json([
            'msg' => 'status successfully changed.', 'status' => 200
        ]);
    }else{
        return response()->json(['status' => 500,'errors'=>["something went wrong."]]);
    }
    }
    public function getUserPackages(){
        $data=User_package::with('Plans_validity')->with('users')->get();
        return response()->json([
            'data' => $data, 'status' => 200
        ]);
    }
    public function getContact(){
        $data=Contact::get();
        return response()->json([
            'data' => $data, 'status' => 200
        ]);
    }
    public function getComments(){
        $data=Comments::get();
        return response()->json([
            'data' => $data, 'status' => 200
        ]);
    }
    public function getLogistic(){
        $data=Logistics::get();
        return response()->json([
            'data' => $data, 'status' => 200
        ]);
    }
    public function saveLogistic(Request $request){
        $validator = \Validator::make($request->all(), [
            'dispatch' => ['required'],
            'movement' => ['required'],
            'load' => ['required'],
            'uploadport' => ['required'],
            'ship_rec' => ['required'],
            'quantity' => ['required'],
            'unit' => ['required'],
            'status' => ['required'],
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $mytime = Carbon::now();
        $start = $mytime->toDateTimeString();
        $dispatch =  gmdate('Y-m-d',strtotime('+1 day', strtotime($request->input('dispatch')) ));
            $User_package_services = new Logistics();
            $User_package_services->user_id = Auth::user()->id;
            $User_package_services->movement = $request->input('movement');
            $User_package_services->load = $request->input('load');
            $User_package_services->unload = $request->input('uploadport');
            $User_package_services->ship_rec = $request->input('ship_rec');
            $User_package_services->quantity = $request->input('quantity');
            $User_package_services->unit = $request->input('unit');
            $User_package_services->cargo = $request->input('cargo');
            $User_package_services->vessal = $request->input('vessal');
            $User_package_services->dispatch = $dispatch;
            $User_package_services->log_status = $request->input('status');
            $User_package_services->posted_date	 = $start;
            
            $User_package_services->save(); 


            return response()->json([
                'msg' => 'status successfully changed.', 'status' => 200
            ]);
    }
    public function saveComment(Request $request){
        $validator = \Validator::make($request->all(), [
            
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $User_package_services = new Comments();
        $User_package_services->user_id = Auth::user()->id;
        $User_package_services->user_id = Auth::user()->id;
        $User_package_services->user_id = Auth::user()->id;
        $User_package_services->user_id = Auth::user()->id;
        $User_package_services->user_id = Auth::user()->id;
        $User_package_services->save();


        return response()->json([
            'msg' => 'status successfully changed.', 'status' => 200
        ]);

    }
}
