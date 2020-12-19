<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\FeatureMaster;
use Session;
use Helper; 
use DB;

class PackageFeatureController extends Controller
{

    /*
    * Package Feature List
    */
    
    public function index(Request $request){

        $name = $request->get('name');

        try{
           
            $arrFeatures = FeatureMaster::select('features_master.*');
                                    if($name){
                                        $arrFeatures->where('name', 'like', '%'.$name.'%');
                                    }
            $arrFeatures = $arrFeatures->orderBy('id', 'desc')->paginate(10);

            return view('admin.packagefeature.index', compact('arrFeatures'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }       
    }

    /*
    * Package Feature Add
    */

    public function add(){
        
        return view('admin.packagefeature.add');
    }

    /*
    * Package Feature Store
    */

    public function store(Request $request){
            
        $this->validate($request,[
            'feature_name'  => 'required',
        ]);


        try{

            DB::beginTransaction();

            $feature                = new FeatureMaster;
            $feature->feature_name  = $request->feature_name;
            $feature->description   = $request->description;
            $feature->status        = 1;
            $feature->save();

            if($request->feature_img){
                
                $img = $request->feature_img;
                $name               = time().'.'.$img->getClientOriginalExtension();
                $destinationPath    = public_path('/images/package_feature/');
                $destinationThumb   = public_path('/images/package_feature/thumbnail/');
                $destinationIcon    = public_path('/images/package_feature/icon/');
                $img->move($destinationPath, $name);
                Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);
                $feature->feature_img = $name;
                $feature->save();

            }

            DB::commit();
            return redirect('admin/package/feature')->with('success', 'Feature added successfully');
            
         }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }
        
        /*
        * Package Feature Edit
        */

        public function edit($id){

            $dataFeature = FeatureMaster::where('id', $id)->first();
            return view('admin.packagefeature.edit', compact('dataFeature'));   
              
        }

        public function update(Request $request, $id){
        
            $this->validate($request,[
                'feature_name'  => 'required',
            ]);

            try{
                
                DB::beginTransaction();

                $feature                = FeatureMaster::find($id);
                $feature->feature_name  = $request->feature_name;
                $feature->description   = $request->description;
                $feature->save();
                
                if($request->feature_img){
                    
                    $oldImgName = FeatureMaster::where('id', $id)->first();

                    $destinationPath    = public_path('/images/package_feature/');
                    $destinationThumb   = public_path('/images/package_feature/thumbnail/');
                    $destinationIcon    = public_path('/images/package_feature/icon/');

                    if(!empty($oldImgName->feature_img)){
                        
                        unlink($destinationPath.$oldImgName->feature_img);                     
                        unlink($destinationThumb.$oldImgName->feature_img);                     
                        unlink($destinationIcon.$oldImgName->feature_img);                     
                    }
                    
                    $img  = $request->feature_img;
                    $name        = time().'.'.$img->getClientOriginalExtension();
                    
                    $img->move($destinationPath, $name);
                    Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                    Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);

                    $feature->feature_img  = $name;
					$feature->save();
                }
             DB::commit();
            return redirect('admin/package/feature')->with('success', 'Feature updated successfully');

            }catch(\Exception $e){
				 DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }


        public function delete($id){
            
            try{
                FeatureMaster::where('id', $id)->delete();   
                return redirect('admin/feature')->with('success', 'Feature deleted successfully!'); 
            }
            catch (\Exception $ex) {
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }
        public function features_status($id){
        
        $id     = explode('_', $id);
        $db_id  = $id[0];
        $status = $id[1];
       
        if ($status == 1) {
            $changed_status = 0;
            $msg = 'Feature inactive successfully!';
        }if ($status == 0) {
            $changed_status = 1;
            $msg = 'Feature active successfully!';
        }

        try {
            $service = FeatureMaster::find($db_id);
            $service->status = $changed_status;
            $service->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('error', 'Status updation failed. Please Try again!');
        }
        return redirect()->back()->with('success', $msg);
    }

}
