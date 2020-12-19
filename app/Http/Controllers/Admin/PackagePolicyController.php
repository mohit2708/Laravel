<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\PolicyMaster;
use Session;
use Helper; 
use DB;

class PackagePolicyController extends Controller
{

	/*
	* Package Policy List
	*/

	public function index(Request $request){

		$name = $request->get('name');

		try{
            $arrFeaturesPolicy = PolicyMaster::select('policy_master.*');
								if($name){
									$arrFeaturesPolicy->where('policy_name', 'like', '%'.$name.'%');
								}
			$arrFeaturesPolicy = $arrFeaturesPolicy->orderBy('id', 'desc')->paginate(10);
			
            return view('admin.packagepolicy.index', compact('arrFeaturesPolicy'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }		
	}

	/*
	* Package Policy Add
	*/

	public function add(){		
		return view('admin.packagepolicy.add');
	}

	/*
	* Package Policy Add
	*/

	public function store(Request $request){
            
        $this->validate($request,[
            'policy_name'  => 'required',
        ]);


        try{

            DB::beginTransaction();

            $policy                = new PolicyMaster;
            $policy->policy_name = $request->policy_name;
            $policy->description   = $request->description;
            $policy->status        = 1;
            $policy->save();

            if($request->policy_img){
                
                $img = $request->policy_img;
                $name               = time().'.'.$img->getClientOriginalExtension();
                $destinationPath    = public_path('/images/package_policy/');
                $destinationThumb   = public_path('/images/package_policy/thumbnail/');
                $destinationIcon    = public_path('/images/package_policy/icon/');
                $img->move($destinationPath, $name);
                Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);
                $policy->policy_img = $name;
                $policy->save();

            }

            DB::commit();
            return redirect('admin/package/policy')->with('success', 'Policy added successfully');
            
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
    }
    	
    	public function edit($id){
			$dataFeaturepolicy = PolicyMaster::where('id', $id)->first();
			return view('admin.packagepolicy.edit', compact('dataFeaturepolicy'));		
		}

	 public function update(Request $request, $id){
        
            $this->validate($request,[
                'policy_name'  => 'required',
            ]);

            try{
                
                DB::beginTransaction();

                $policy                = PolicyMaster::find($id);
                $policy->policy_name  = $request->policy_name;
                $policy->description   = $request->description;
                $policy->save();
                
                if($request->policy_img){
                    
                    $oldImgName = PolicyMaster::where('id', $id)->first();

                    $destinationPath    = public_path('/images/package_policy/');
                    $destinationThumb   = public_path('/images/package_policy/thumbnail/');
                    $destinationIcon    = public_path('/images/package_policy/icon/');

                    if(!empty($oldImgName->policy_img)){
                        
                        unlink($destinationPath.$oldImgName->policy_img);                     
                        unlink($destinationThumb.$oldImgName->policy_img);                     
                        unlink($destinationIcon.$oldImgName->policy_img);                     
                    }
                    
                    $img  = $request->policy_img;
                    $name        = time().'.'.$img->getClientOriginalExtension();
                    
                    $img->move($destinationPath, $name);
                    Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                    Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);

                    $policy->policy_img  = $name;
                    $policy->save();
                }
             DB::commit();
            return redirect('admin/package/policy')->with('success', 'Policy updated successfully');

            }catch(\Exception $e){
                 DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }


		public function delete($id){
			
			try{
				PolicyMaster::where('id', $id)->delete();	
				return redirect('admin/package/policy')->with('success', 'Feature deleted successfully!');	
			}
			catch (\Exception $ex) {
	            return redirect()->back()->with('error', 'Error occurs! Please try again!');
	        }
		}
    
}