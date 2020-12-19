<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Service;
use App\Coupon;
use App\PackageMaster;
use App\PackageFeatures;
use App\PackageFacilityInclude;
use App\PackageHotelInclude;
use App\PackageLocationDetails;
use App\PackageLocationDetailsImage;
use App\PackageImage;
use Session;
use Helper; 
use DB;

class PackageController extends Controller
{
    
	/*
	* Discount List
	*/
    public function index(Request $request){
        $query = DB::table('package_master');
        if($request->package_name){
            $query = $query->where('package_name',$request->package_name);
        }
        $query = $query->orderBy('id','DESC');
        $data['package'] = $query->paginate();
       return view('admin.package.index',$data); 
    }
    public function create(){

    	$data['features_master'] = Helper::features_master();
    	$data['facility_include_master'] = Helper::facility_include_master();
    	$data['city'] = Helper::get_city();
    	$data['policy'] = Helper::get_policy();
    	$data['discount'] = Helper::get_dicount();

	return view('admin.package.create',$data);
      
    }
    public static function getLocationImage($id){
        
        $image = DB::table('package_location_details_image')->where('package_location_details_id',$id)->get();
        return $image;
    }


    public function package_store(Request $request){
		//print_r($_POST);die;
		$this->validate($request,[
                    'package_name'              => 'required',
                    'package_price'             => 'required',
                    'package_duration_day'	=> 'required',
                    'included_policy'           => 'required',
                    'included_discount'         => 'required',
                    'description'               => 'required',
                    'package_feature'           => 'required',
                    'included_services'     	=> 'required',
                    'hotel_package'             => 'required',
                    'info'                      => 'required',
                    
                ]);
		
        try{
                DB::beginTransaction();
                $package 				= new PackageMaster;
                $package->package_name 			= $request->package_name;
                $package->price 			= $request->package_price;
                $package->package_duration_day 		= $request->package_duration_day;
                $package->policy_master_id 		= $request->included_policy;
                $package->discount_coupan_id 		= $request->included_discount;
                $package->description 			= $request->description;
                $package->status			= 1;
                $package->save();
                $package_id = $package->id;

                //Package Feature 
                $package_feature = $request->package_feature;
                for($i=0;$i<count($package_feature);$i++){

                        $features 							= new PackageFeatures;
                        $features->package_master_id 		= $package_id;
                        $features->features_master_id 		= $package_feature[$i];		
                        $features->status			= 1;
                        $features->save();
                }

                //Facility Includes in package   
                $included_services = $request->included_services;
                for($i=0;$i<count($included_services);$i++){

                        $facility 				= new PackageFacilityInclude;
                        $facility->package_master_id 		= $package_id;
                        $facility->facility_include_master_id 	= $included_services[$i];		
                        $facility->status			= 1;
                        $facility->save();
                }
                //Hotel included in package 
                $hotel_package = $request->hotel_package;
                for($i=0;$i<count($hotel_package);$i++){

                        $hotel 					= new PackageHotelInclude;
                        $hotel->package_master_id 		= $package_id;
                        $hotel->hotel_type_id 			= $hotel_package[$i];		
                        $hotel->hotel_code 			= 0;		
                        $hotel->hotel_price 			= 0;		
                        $hotel->status				= 1;
                        $hotel->save();
                }
                //Location
                $location_info = $request->info;
                //print_r($location_info);die;
                for($i=0;$i<count($location_info);$i++){

                        $location 				= new PackageLocationDetails;
                        $location->package_master_id 		= $package_id;
                        $location->city_id 			= $location_info[$i]['location'];		
                        $location->number_of_day 		= $location_info[$i]['location_day'];		
                        $location->description 			= $location_info[$i]['location_desc'];		
                        $location->status			= 1;
                        $location->save();
                        $package_location_id = $location->id;
                            
                            if(isset($location_info[$i]['location_image'])) {
                            $location_image = $location_info[$i]['location_image'];
                            for($j=0;$j<count($location_image);$j++){

                                $image = $location_image[$j];
                                $name = $j.time().'.'.$image->getClientOriginalExtension();
                                $destinationPath = public_path('/images/package_image/location_image/');
                                $destinationThub = public_path('/images/package_image/location_image/thumbnail/');
                                $image->move($destinationPath, $name);
                                $image = Image::make($destinationPath.$name)->resize(300,300)->save($destinationThub.$name);

                                $location_db                                 = new PackageLocationDetailsImage;
                                $location_db->package_master_id              = $package_id;
                                $location_db->package_location_details_id    = $package_location_id;
                                $location_db->image_name                     = $name;	
                                $location_db->save();
                            }
                            }
                            
                            
                }
                //package image
                $package_images = $request->package_images;
                for($i=0;$i<count($package_images);$i++){

                        $pimage = $package_images[$i];
                        $pname = time().'.'.$pimage->getClientOriginalExtension();
                        $destinationPath = public_path('/images/package_image/');
                        $destinationThub = public_path('/images/package_image/thumbnail/');
                        $pimage->move($destinationPath, $pname);
                        $pimage = Image::make($destinationPath.$pname)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThub.$pname);

                        $package_image                      = new PackageImage;
                        $package_image->package_master_id   = $package_id;
                        $package_image->image_name 	    = $pname;		
                        $package_image->status              = 1;
                        $package_image->save();
                }

                DB::commit();
                return redirect('admin/package')->with('success', 'Package added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
    
    public function package_edit(Request $request){

    	$data['features_master'] = Helper::features_master();
    	$data['facility_include_master'] = Helper::facility_include_master();
    	$data['city'] = Helper::get_city();
    	$data['policy'] = Helper::get_policy();
    	$data['discount'] = Helper::get_dicount();
        $data['hotel_type'] = DB::table('hotel_type_master')->where('status',1)->get();
        $data['package_data'] = DB::table('package_master')->where('id',$request->id)->first();
        $data['package_features'] = DB::table('package_features')->where('package_master_id',$request->id)->select('features_master_id')->get();
        $data['package_facility'] = DB::table('package_facility_include')->where('package_master_id',$request->id)->select('facility_include_master_id')->get();
        $data['package_hotel'] = DB::table('package_hotel_include')->where('package_master_id',$request->id)->select('hotel_type_id','hotel_code','hotel_price')->get();
        $data['package_location'] = DB::table('package_location_details')->where('package_master_id',$request->id)->select('id','city_id','number_of_day','description')->get();
        $data['package_image'] = DB::table('package_image')->where('package_master_id',$request->id)->select('id','image_name')->get();
	return view('admin.package.edit',$data);
      
    }
    
    public function package_update(Request $request){



           /* $location_db                         = new PackageLocationDetailsImage;
            $location_db->package_master_id              = 1;
            $location_db->package_location_details_id    = 2;
            $location_db->image_name                     = 'aaa';    
            $location_db->save();
           
           die;*/

        $this->validate($request,[
                    'package_name'              => 'required',
                    'package_price'             => 'required',
                    'package_duration_day'	=> 'required',
                    'included_policy'           => 'required',
                    'included_discount'         => 'required',
                    'description'               => 'required',
                    'package_feature'           => 'required',
                    'included_services'     	=> 'required',
                    'info'                      => 'required',
                    
                ]);
		
        try{
                DB::beginTransaction();
                $package 				= PackageMaster::find($request->id);
                $package->package_name 			= $request->package_name;
                $package->price 			= $request->package_price;
                $package->package_duration_day 		= $request->package_duration_day;
                $package->policy_master_id 		= $request->included_policy;
                $package->discount_coupan_id 		= $request->included_discount;
                $package->description 			= $request->description;
                $package->status			= 1;
                $package->save();
                $package_id = $request->id;

                //Package Feature delete
                PackageFeatures::where('package_master_id',$package_id)->delete();
                $package_feature = $request->package_feature;
                for($i=0;$i<count($package_feature);$i++){

                        $features 				= new PackageFeatures;
                        $features->package_master_id 		= $package_id;
                        $features->features_master_id 		= $package_feature[$i];		
                        $features->status			= 1;
                        $features->save();
                }

                //Facility Includes in package 
                PackageFacilityInclude::where('package_master_id',$package_id)->delete();
                $included_services = $request->included_services;
                for($i=0;$i<count($included_services);$i++){

                        $facility 				= new PackageFacilityInclude;
                        $facility->package_master_id 		= $package_id;
                        $facility->facility_include_master_id 	= $included_services[$i];		
                        $facility->status			= 1;
                        $facility->save();
                }
                //Hotel included in package 
                $hotel_package = $request->hotel_package;
                PackageHotelInclude::where('package_master_id',$package_id)->delete();
                for($i=0;$i<count($hotel_package);$i++){

                        $hotel 					= new PackageHotelInclude;
                        $hotel->package_master_id 		= $package_id;
                        $hotel->hotel_type_id 			= $hotel_package[$i];		
                        $hotel->hotel_code 			= 0;		
                        $hotel->hotel_price 			= 0;		
                        $hotel->status				= 1;
                        $hotel->save();
                }
                //Location
                $location_info = $request->info;
                //print_r($location_info);die;
                for($i=0;$i<count($location_info);$i++){

                        if(isset($location_info[$i]['id'])) {

                        $location 				      = PackageLocationDetails::find($location_info[$i]['id']);
                        $location->package_master_id = $package_id;
                        $location->city_id 			  = $location_info[$i]['location'];		
                        $location->number_of_day 	= $location_info[$i]['location_day'];		
                        $location->description 		= $location_info[$i]['location_desc'];		
                        $location->status			= 1;
                        $location->save();


                            $package_location_id = $location_info[$i]['id'];
                            
                            if(isset($location_info[$i]['location_image'])) {

                                $location_image = $location_info[$i]['location_image'];

                              /*  echo '<pre>';
                                print_r($location_image);die;*/
                                $n = 1;
                                foreach($location_image as $loc_img){


                                    $name = $n.time().'.'.$loc_img->getClientOriginalExtension();

                                    $destinationPath = public_path('/images/package_image/location_image/');
                                    $destinationThub = public_path('/images/package_image/location_image/thumbnail/');
                                    $loc_img->move($destinationPath, $name);
                                    $loc_img = Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThub.$name);

                                    $location_db                         = new PackageLocationDetailsImage;
                                    $location_db->package_master_id              = $package_id;
                                    $location_db->package_location_details_id    = $package_location_id;
                                    $location_db->image_name                     = $name;    
                                    $location_db->save();
                                    $n++;
                                }

                                //die;

                                /*for($x=0; $x<count($location_image); $x++){
                                        
                                    $limage = $location_image[$x];
                                    if ($limage !== null) {
                                    $name = $x.time().'.'.$limage->getClientOriginalExtension();
                                    $destinationPath = public_path('/images/package_image/location_image/');
                                    $destinationThub = public_path('/images/package_image/location_image/thumbnail/');
                                    $limage->move($destinationPath, $name);
                                    $limage = Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThub.$name);

                                    $location_image                                 = new PackageLocationDetailsImage;
                                    $location_image->package_master_id              = $package_id;
                                    $location_image->package_location_details_id    = $package_location_id;
                                    $location_image->image_name                     = $name;	
                                    $location_image->save();
                                    }
                                }*/
                          
                         
                            }
                        } else {
                            $location 				= new PackageLocationDetails;
                            $location->package_master_id 	= $package_id;
                            $location->city_id 			= $location_info[$i]['location'];		
                            $location->number_of_day 		= $location_info[$i]['location_day'];		
                            $location->description 		= $location_info[$i]['location_desc'];		
                            $location->status			= 1;
                            $location->save();
                            $package_location_id = $location->id;

                                if(isset($location_info[$i]['location_image'])) {
                                $location_image = $location_info[$i]['location_image'];
                                for($j=0;$j<count($location_image);$j++){

                                    $image = $location_image[$j];
                                    $name = $j.time().'.'.$image->getClientOriginalExtension();
                                    $destinationPath = public_path('/images/package_image/location_image/');
                                    $destinationThub = public_path('/images/package_image/location_image/thumbnail/');
                                    $image->move($destinationPath, $name);
                                    $image = Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThub.$name);

                                    $location_image                                 = new PackageLocationDetailsImage;
                                    $location_image->package_master_id              = $package_id;
                                    $location_image->package_location_details_id    = $package_location_id;
                                    $location_image->image_name                     = $name;	
                                    $location_image->save();
                                }
                            }
                            
                        }            

                }
                //package image
                $package_images = $request->package_images;
                if(isset($package_images)) {
                for($i=0;$i<count($package_images);$i++){

                        $pimage = $package_images[$i];
                        $pname = time().'.'.$pimage->getClientOriginalExtension();
                        $destinationPath = public_path('/images/package_image/');
                        $destinationThub = public_path('/images/package_image/thumbnail/');
                        $pimage->move($destinationPath, $pname);
                        $pimage = Image::make($destinationPath.$pname)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThub.$pname);

                        $package_image                      = new PackageImage;
                        $package_image->package_master_id   = $package_id;
                        $package_image->image_name 	    = $pname;		
                        $package_image->status              = 1;
                        $package_image->save();
                } }
                
                DB::commit();
                return redirect('admin/package/list')->with('success', 'Package Updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
        
        
    }
    public function itinarary_delete(Request $request){
       
        try {
             DB::beginTransaction();
            $oldImgName = PackageLocationDetailsImage::where('package_location_details_id',$request->location_id)->get();

            $destinationPath    = public_path('/images/package_image/location_image/');
            $destinationThumb   = public_path('/images/package_image/location_image/thumbnail/');

            foreach($oldImgName as $img) {
                if(!empty($img->image_name)){

                    unlink($destinationPath.$img->image_name);                     
                    unlink($destinationThumb.$img->image_name);                     

                }
            }
             PackageLocationDetailsImage::where('package_location_details_id',$request->location_id)->delete();
             PackageLocationDetails::where('id',$request->location_id)->delete();
             DB::commit();
             return redirect('admin/package/edit/'.$request->location_package_id)->with('success', 'Itinarary Deleted successfully');
        } catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        } 
        
    }
    public function itinarary_image_delete(Request $request){
        //print_r($_POST);die;
        try {
             DB::beginTransaction();
            $oldImgName = PackageLocationDetailsImage::where('id',$request->location_details_id)->first();
            //print_r($oldImgName->image_name);die;
            $destinationPath    = public_path('/images/package_image/location_image/');
            $destinationThumb   = public_path('/images/package_image/location_image/thumbnail/');

                if(!empty($oldImgName->image_name)){

                    unlink($destinationPath.$oldImgName->image_name);                     
                    unlink($destinationThumb.$oldImgName->image_name);                     

                }
            
             PackageLocationDetailsImage::where('id',$request->location_details_id)->delete();
             
             DB::commit();
             return redirect('admin/package/edit/'.$request->location_details_package_id)->with('success', 'Itinarary Image Deleted successfully');
        } catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        } 
    }
    public function package_image_delete(Request $request){
       // print_r($_POST);die;
         try {
             DB::beginTransaction();
            $oldImgName = PackageImage::where('id',$request->package_image_id)->first();
            //print_r($oldImgName->image_name);die;
            $destinationPath    = public_path('/images/package_image/');
            $destinationThumb   = public_path('/images/package_image/thumbnail/');

                if(!empty($oldImgName->image_name)){

                    unlink($destinationPath.$oldImgName->image_name);                     
                    unlink($destinationThumb.$oldImgName->image_name);                     

                }
            
             PackageImage::where('id',$request->package_image_id)->delete();
             
             DB::commit();
             return redirect('admin/package/edit/'.$request->package_id)->with('success', 'Package Image Deleted successfully');
        } catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
    public function package_status($id){
        
        $id     = explode('_', $id);
        $db_id  = $id[0];
        $status = $id[1];
       // $service = PackageMaster::find($db_id);
        if ($status == 1) {
            $changed_status = 0;
            $msg = 'Package inactive successfully!';
        }if ($status == 0) {
            $changed_status = 1;
            $msg = 'Package active successfully!';
        }

        try {
            $service = PackageMaster::find($db_id);
            $service->status = $changed_status;
            $service->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('error', 'Status updation failed. Please Try again!');
        }
        return redirect()->back()->with('success', $msg);
    }
}
