<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Deals;
use App\DealsImage;
use Session;
use Helper; 
use DB;

class DealsController extends Controller
{
    
	/*
	* Deals List
	*/
	
    public function index(Request $request){
				
		$name = $request->get('name');
        try{
            $arrDeal = Deals::select('flight_deals.*');
									if($name){
										$arrDeal->where('deal_name', 'like', '%'.$name.'%');
									}
			$arrDeal = $arrDeal->orderBy('id', 'desc')
									->paginate(10);
			
            return view('admin.deals.index', compact('arrDeal'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }
    }
	
	/*
	* Deals Add Get Method
	*/
	
	public function add(){
		
		return view('admin.deals.add');
	}
	
	
	/*
	* Deals Store
	*/
	
    public function store(Request $request){
			
        $this->validate($request,[
            'deals_name'	=> 'required',
            //'deal_from'	=> 'required',
           // 'deal_to'		=> 'required',
           // 'deal_desc'	=> 'required',
           // 'max_flight'	=> 'required',            
        ]);
		
		try{
			
			DB::beginTransaction();

			$deals 				= new Deals;
			$deals->deal_name 	= $request->deals_name;
			$deals->deal_from 	= $request->flight_from;
			$deals->deal_to 	= $request->flight_to;
			$deals->deal_desc 	= $request->description;
			$deals->max_flight 	= $request->flight_count;			
			$deals->save();

			if($request->deals_image){

				$image = $request->deals_image;

				$destinationPath = public_path('/images/deals/'); 
				$destinationThub = public_path('/images/deals/thumbnail/'); 
				$filename = time() . '.' . $image->getClientOriginalExtension();
				$image->move($destinationPath, $filename);
						

				$pimage = Image::make($destinationPath.$filename)->resize(760,428)->save($destinationThub.$filename);

				$dealsImage				= new DealsImage;
				$dealsImage->fd_id 		= $deals->id;
				$dealsImage->img_name 	= $filename;
				$dealsImage->save();

			}

			DB::commit();
            return redirect('admin/deals')->with('success', 'Deal added successfully');
			
        }catch(\Exception $e){
        	DB::rollback();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }
	
	/*
	* Deals Edit
	*/
	
	public function edit($id){
		
		$dataDeals = Deals::select('flight_deals.*','flight_deals_img.img_name as img')
							->leftjoin('flight_deals_img','flight_deals_img.fd_id','=','flight_deals.id')
							->where('flight_deals.id', $id)
							->first();

		return view('admin.deals.edit', compact('dataDeals'));
		
	}
	
	/*
	* Deals Update
	*/

    public function update(Request $request, $id){

    	/*echo '<pre>';
    	print_r($request->all()); die;*/
		
		$this->validate($request,[
            'deals_name'	=> 'required',
        ]);

        try{
			DB::beginTransaction();
			$deals 				= Deals::find($id);			
			$deals->deal_name 	= $request->deals_name;
			$deals->deal_from 	= $request->flight_from;
			$deals->deal_to 	= $request->flight_to;
			$deals->deal_desc 	= $request->description;
			$deals->max_flight 	= $request->flight_count;
			$deals->save();




			if($request->deals_image){

				$oldImgName = DealsImage::where('fd_id', $id)->first();

				$destinationPath = public_path('/images/deals/'); 
				$destinationThub = public_path('/images/deals/thumbnail/'); 

				if(!empty($oldImgName)){
					unlink($destinationPath.'/'.$oldImgName->img_name);						
					unlink($destinationThub.'/'.$oldImgName->img_name);						
				}

				$image = $request->deals_image;
				$filename = time() . '.' . $image->getClientOriginalExtension();
				$image->move($destinationPath, $filename);
				$pimage = Image::make($destinationPath.$filename)->resize(760,428)->save($destinationThub.$filename);


				DealsImage::where('fd_id', $id)->update(['img_name' => $filename]);

			}

			DB::commit();
            return redirect('admin/deals')->with('success', 'Deals updated successfully');

		}catch(\Exception $e){
	    	DB::rollback();
			return redirect()->back()->with('error', 'Error occurs! Please try again!'. $e->getMessage());
		}
    }
	
	/*
	* Deals Delete
	*/
	
	public function delete($id){

		try{

			$oldImgName = DealsImage::where('fd_id', $id)->first();
			$destinationPath = public_path('/images/deals/'); 
			$destinationThub = public_path('/images/deals/thumbnail/'); 
			if(!empty($oldImgName)){
				unlink($destinationPath.'/'.$oldImgName->img_name);						
				unlink($destinationThub.'/'.$oldImgName->img_name);						
			}

			Deals::where('id', $id)->delete();	
			DealsImage::where('fd_id', $id)->delete();	

			return redirect('admin/deals')->with('success', 'deals deleted successfully!');	
		}
		catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
	}
	
	
}
