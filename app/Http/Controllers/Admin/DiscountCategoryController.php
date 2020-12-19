<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\DiscountCategory;
use Session;
use Helper; 
use DB;

class DiscountCategoryController extends Controller
{

	/*
	* Discount Category List
	*/

	public function index(Request $request){

		$name = $request->get('name');

		try{
            $arrDiscountCategory = DiscountCategory::select('*');
								if($name){
									$arrDiscountCategory->where('category_name', 'like', '%'.$name.'%');
								}
			$arrDiscountCategory = $arrDiscountCategory->orderBy('id', 'desc')->paginate(10);
			
            return view('admin.discount.category.index', compact('arrDiscountCategory'));

        }catch(\Exception $ex){ 
            return redirect()->back()->with('error', 'Error occurred. Please Try again!');
        }		
	}

	/*
	* Discount Category Add
	*/

	public function add(){		
		return view('admin.discount.category.add');
	}

	/*
	* Discount Category Add
	*/

	public function store(Request $request){
            
        $this->validate($request,[
            'category_name'  => 'required',
        ]);


        try{

            DB::beginTransaction();

            $category                = new DiscountCategory;
            $category->category_name  = $request->category_name;
            $category->description   = $request->description;
            $category->status        = 1;
            $category->save();

            if($request->category_img){
                
                $img = $request->category_img;
                $name               = time().'.'.$img->getClientOriginalExtension();
                $destinationPath    = public_path('/images/discount_category/');
                $destinationThumb   = public_path('/images/discount_category/thumbnail/');
                $destinationIcon    = public_path('/images/discount_category/icon/');
                $img->move($destinationPath, $name);
                Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);
                $category->category_img = $name;
                $category->save();

            }

            DB::commit();
            return redirect('admin/discount/category')->with('success', 'Category added successfully');
            
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
    }
    	
    	public function edit($id){
			$dataDiscountCat = DiscountCategory::where('id', $id)->first();
			return view('admin.discount.category.edit', compact('dataDiscountCat'));		
		}

	 public function update(Request $request, $id){
        
            $this->validate($request,[
                'category_name'  => 'required',
            ]);

            try{
                
                DB::beginTransaction();

                $category                = DiscountCategory::find($id);
                $category->category_name  = $request->category_name;
                $category->description   = $request->description;
                $category->save();
                
                if($request->category_img){
                    
                    $oldImgName = DiscountCategory::where('id', $id)->first();

                    $destinationPath    = public_path('/images/discount_category/');
                    $destinationThumb   = public_path('/images/discount_category/thumbnail/');
                    $destinationIcon    = public_path('/images/discount_category/icon/');

                    if(!empty($oldImgName->category_img)){
                        
                        unlink($destinationPath.$oldImgName->category_img);                     
                        unlink($destinationThumb.$oldImgName->category_img);                     
                        unlink($destinationIcon.$oldImgName->category_img);                     
                    }
                    
                    $img  = $request->category_img;
                    $name        = time().'.'.$img->getClientOriginalExtension();
                    
                    $img->move($destinationPath, $name);
                    Image::make($destinationPath.$name)->resize(config('custom.THUMBNAIL_W'),config('custom.THUMBNAIL_H'))->save($destinationThumb.$name);
                    Image::make($destinationPath.$name)->resize(config('custom.ICON_W'),config('custom.ICON_W'))->save($destinationIcon.$name);

                    $category->category_img  = $name;
                    $category->save();
                }
             DB::commit();
            return redirect('admin/discount/category')->with('success', 'Category updated successfully');

            }catch(\Exception $e){
                 DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }


		public function delete($id){
			
			try{
				DiscountCategory::where('id', $id)->delete();	
				return redirect('admin/discount/category')->with('success', 'Category deleted successfully!');	
			}
			catch (\Exception $ex) {
	            return redirect()->back()->with('error', 'Error occurs! Please try again!');
	        }
		}
    
}