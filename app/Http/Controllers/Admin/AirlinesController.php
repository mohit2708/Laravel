<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
//use App\Currency;
use App\Airlines;
use Session;
use Helper; 
use DB;

class AirlinesController extends Controller
{
	public function index(Request $request){
		
		

		$name = $request->get('name');
		
		try{
            $arrAirlines = Airlines::select('airlines.*');
									if($name){
										$arrAirlines->where('name', 'like', '%'.$name.'%');
									}
			$arrAirlines = $arrAirlines->orderBy('id', 'desc')
									->paginate(10);
			
            return view('admin.airlines.index', compact('arrAirlines'));

        }
        catch(\Illuminate\Database\QueryException $ex){
	        		DB::rollback();
	            return redirect()->back()->with('error', $ex->errorInfo[2])->withInput();
	        }catch(\Exception $ex){ 
        	
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }		
	}

	public function add(){
		
		return view('admin.airlines.add');
	}

	  public function store(Request $request){
			
        $this->validate($request,[
            'airlines_name'	=> 'required',
            'short_code'	=> 'required',
        ]);
		
		try{
			DB::beginTransaction();

            $airline                = new Airlines;
            $airline->airlines_name = $request->airlines_name;
            $airline->short_code    = $request->short_code;
            $airline->save();

            if($request->airlines_logo){
                
                $img = $request->airlines_logo;
                $name               = time().'.'.$img->getClientOriginalExtension();
                $destinationPath    = public_path('/images/airlines/');
                $destinationThumb   = public_path('/images/airlines/thumbnail/');
                $destinationIcon    = public_path('/images/airlines/icon/');
                $img->move($destinationPath, $name);
                Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);
                $airline->airlines_logo = $name;
                $airline->save();

            }

            DB::commit();
            return redirect('admin/master/airlines')->with('success', 'Airlines added successfully');
			
	       } catch(\Exception $e){
	        	DB::rollback();
	            return redirect()->back()->with('error', 'Error occurs! Please try again!');
	            
	       }
    	}
    	
    	public function edit($id){		
			$dataAirlines = Airlines::where('id', $id)->first();
			return view('admin.airlines.edit', compact('dataAirlines'));		
		}

		public function update(Request $request, $id){
		
			$this->validate($request,[
	            'airlines_name'	=> 'required',
	            'short_code'	=> 'required',
	        ]);
		

	       try{

	        	DB::beginTransaction();

                $airline                = Airlines::find($id);
	            $airline->airlines_name = $request->airlines_name;
	            $airline->short_code    = $request->short_code;
	            $airline->save();
                
                if($request->airlines_logo){
                    
                    $oldImgName = Airlines::where('id', $id)->first();

                    $destinationPath    = public_path('/images/airlines/');
                    $destinationThumb   = public_path('/images/airlines/thumbnail/');
                    $destinationIcon    = public_path('/images/airlines/icon/');

                    if(!empty($oldImgName->airlines_logo)){
                        
                        unlink($destinationPath.$oldImgName->airlines_logo);                     
                        unlink($destinationThumb.$oldImgName->airlines_logo);                     
                        unlink($destinationIcon.$oldImgName->airlines_logo);                     
                    }
                    
                    $img  = $request->airlines_logo;
                    $name        = time().'.'.$img->getClientOriginalExtension();
                    
                    $img->move($destinationPath, $name);
                    Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                    Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);

                    $airline->airlines_logo  = $name;
                    $airline->save();
                }	
				
			
            return redirect('admin/master/airlines')->with('success', 'Airlines updated successfully');

			}catch(\Exception $e){
    		 	DB::rollback(); 
				 return redirect()->back()->with('error', 'Error occurs! Please try again!');
			}
    	}


		public function delete($id){
			
			try{
				Airlines::where('id', $id)->delete();	
				return redirect('admin/master/airlines')->with('success', 'Airlines deleted successfully!');	
			}
			catch (\Exception $ex) {
	            return redirect()->back()->with('error', 'Error occurs! Please try again!');
	        }
		}
    
}