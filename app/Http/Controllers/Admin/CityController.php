<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;
use App\Country;
use App\State;
use Session;
use Helper; 
use DB;

class CityController extends Controller
{
	public function index(Request $request){


		$name = $request->get('name');
		$country = $request->get('country');
		$state = $request->get('state');
		$arrState	= State::get();
		$arrCountry	= Country::get();
		#try{
            $mastercity = City::select('city.*', 'countries.name as country_name', 'states.name as state_name');
									if($name){
										$mastercity->where('city.name', 'like', '%'.$name.'%');
									}
									if($country){
										$mastercity->where('countries.id',$country);
									}
									if($state){
										$mastercity->where('states.id',$state);
									}
			$mastercity = $mastercity->leftjoin('countries', 'countries.id', '=', 'city.country_id')
									->leftjoin('states', 'states.id', '=', 'city.state_id')
									->orderBy('id', 'desc')

									->paginate(10);


			
            return view('admin.mastercity.index', compact('mastercity','arrState', 'arrCountry'));

        #}catch(\Exception $ex){ 
            #return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        #}		
	}

	public function add(){
		$arrState	= State::get();
		$arrCountry	= Country::get();
		return view('admin.mastercity.add', compact('arrState', 'arrCountry'));
		//return view('admin.mastercity.add');
	}

	  public function store(Request $request){
			
        $this->validate($request,[
        	'master_city' => 'required',
            'country'	=> 'required',
            'state' => 'required',           
            'city_description' => 'required',
        ]);
		
		try{
			DB::beginTransaction();
			$filename = "";
			$image = $request->city_image;
			if(!empty($image)){
			$path = public_path()."/images/city";
		    $filename = time() . '.' . $image->getClientOriginalExtension();
		    $image->move($path, $filename);	
			}
		    

			$feature 				= new City;
			$feature->name 			= $request->master_city;
			$feature->country_id 	= $request->country;			
			$feature->state_id 		= $request->state;
			$feature->city_image 	= $filename;	
			$feature->description	= $request->city_description;
			$feature->status 		= 1;
			$feature->save();
			DB::commit();
            return redirect('admin/master/city')->with('success', 'Feature added successfully')->withInput();
			
	        } catch(\Illuminate\Database\QueryException $ex){
	        		DB::rollback();
	            return redirect()->back()->with('error', $ex->errorInfo[2])->withInput();
	        }catch(\Exception $e){
	        	DB::rollback();
	            return redirect()->back()->with('error', 'Error occurs! Please try again!')->withInput();
	            
	        }
    	}
    	
    	public function edit($id){

    	$arrCountry = Country::get();
    	$arrState	= State::get();
		$arrCity 	= City::get();
		$dataMastercity = City::where('id', $id)->first();

		return view('admin.mastercity.edit', compact('dataMastercity','arrCountry','arrCity','arrState'));

		}

		public function update(Request $request, $id){
			


	        try{

	        	$image = $request->city_image;
	        	$oldimage = $request->cityoldimage;
			    $path = public_path()."/images/city";
			    $filename = time() . '.' . $image->getClientOriginalExtension();
			    $image->move($path, $filename);
				
				$feature 				= City::find($id);
				$feature->name 			= $request->City_name;
				$feature->country_id 	= $request->country;
				$feature->state_id		= $request->state;
				$feature->city_image 	= $filename;
				$feature->description	= $request->city_description;	
							
				$feature->save();
				if(!empty($oldimage)){
					unlink($path.'/'.$oldimage);
				}
				
            return redirect('admin/city')->with('success', 'City updated successfully');

			}catch(\Illuminate\Database\QueryException $ex){
	        		DB::rollback();
	            return redirect()->back()->with('error', $ex->errorInfo[2])->withInput();
	        }
			catch(\Exception $e){
				return redirect()->back()->with('error', 'Error occurs! Please try again!');
			}
    	}


		public function delete($id){
			
			try{
				City::where('id', $id)->delete();	
				return redirect('admin/master/city')->with('success', 'City deleted successfully!');	
			}
			catch (\Exception $ex) {
	            return redirect()->back()->with('error', 'Error occurs! Please try again!');
	        }
		}

		public function ajaxCity(Request $request){
		
		$input = $request->all();
		
		if(!empty($input)){
			
			$countryID = $request->get('id');
			
			$data = State::select('id', 'name')
						->where('country_id', $countryID)
						->orderBy('name', 'asc')
						->get();
			
			return json_encode($data);
			
		}
		
	}
    
}