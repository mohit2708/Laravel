<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\FacilityMaster;
use Session;
use Helper; 
use DB;

class PackageFacilityController extends Controller
{
	public function index(Request $request){	
		
		$name = $request->get('name');
		try{
            $arrFeaturesFacility = FacilityMaster::select('*');
									if($name){
										$arrFeaturesFacility->where('facility_name', 'like', '%'.$name.'%');
									}
			$arrFeaturesFacility = $arrFeaturesFacility->orderBy('id', 'desc')
									->paginate(10);
			/*echo '<pre>';
			print_r($arrFeaturesFacility); die;*/
            return view('admin.packagefacility.index', compact('arrFeaturesFacility'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
	}

	public function add(){		
		
		return view('admin.packagefacility.add');
	}

	/*
    * Package Facility Store
    */

    public function store(Request $request){
            
        $this->validate($request,[
            'facility_name'  => 'required',
        ]);


        try{

            DB::beginTransaction();

            $facility                = new FacilityMaster;
            $facility->facility_name = $request->facility_name;
            $facility->description   = $request->description;
            $facility->status        = 1;
            $facility->save();

            if($request->facility_img){
                
                $img = $request->facility_img;
                $name               = time().'.'.$img->getClientOriginalExtension();
                $destinationPath    = public_path('/images/package_facility/');
                $destinationThumb   = public_path('/images/package_facility/thumbnail/');
                $destinationIcon    = public_path('/images/package_facility/icon/');
                $img->move($destinationPath, $name);
                Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);
                $facility->facility_img = $name;
                $facility->save();

            }

            DB::commit();
            return redirect('admin/package/facility')->with('success', 'Facility added successfully');
            
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }
    	
    	public function edit($id){		
			$dataFeaturefacility = FacilityMaster::where('id', $id)->first();
			return view('admin.packagefacility.edit', compact('dataFeaturefacility'));		
		}

		 public function update(Request $request, $id){
        
            $this->validate($request,[
                'facility_name'  => 'required',
            ]);

            try{
                
                DB::beginTransaction();

                $facility                = FacilityMaster::find($id);
                $facility->facility_name  = $request->facility_name;
                $facility->description   = $request->description;
                $facility->save();
                
                if($request->facility_img){
                    
                    $oldImgName = FacilityMaster::where('id', $id)->first();

                    $destinationPath    = public_path('/images/package_facility/');
                    $destinationThumb   = public_path('/images/package_facility/thumbnail/');
                    $destinationIcon    = public_path('/images/package_facility/icon/');

                    if(!empty($oldImgName->facility_img)){
                        
                        unlink($destinationPath.$oldImgName->facility_img);                     
                        unlink($destinationThumb.$oldImgName->facility_img);                     
                        unlink($destinationIcon.$oldImgName->facility_img);                     
                    }
                    
                    $img  = $request->facility_img;
                    $name        = time().'.'.$img->getClientOriginalExtension();
                    
                    $img->move($destinationPath, $name);
                    Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                    Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);

                    $facility->facility_img  = $name;
                    $facility->save();
                }
             DB::commit();
            return redirect('admin/package/facility')->with('success', 'Facility updated successfully');

            }catch(\Exception $e){
                 DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }


		public function delete($id){
			
			try{
				FacilityMaster::where('id', $id)->delete();	
				return redirect('admin/package/facility')->with('success', 'Feature deleted successfully!');	
			}
			catch (\Exception $ex) {
	            return redirect()->back()->with('error', 'Error occurs! Please try again!');
	        }
		}
    
}