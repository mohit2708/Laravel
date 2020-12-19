<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\DiscountCoupon;
use App\DiscountCouponService;
use App\DiscountOffer;
use App\DiscountOfferService;
use Session;
use Helper; 
use DB;

class DiscountController extends Controller
{
    
    /*
    * Discount Coupon
    */
    
    public function discountCoupon(Request $request){

        $couponName = $request->coupon_name;

        $arrDiscountCoupon = DiscountCoupon::select('discount_coupons.*')
                                            ->where('status', 1);
                                            if($couponName){
                                                $arrDiscountCoupon->where('coupon_name', 'like', '%'.$couponName.'%');
                                            }
        $arrDiscountCoupon = $arrDiscountCoupon->paginate(10);
       
        return view('admin.discount.coupon_list', compact('arrDiscountCoupon'));
      
    }

    /*
    * Add Discount Coupon
    */

    public function addDiscountCoupon(){

        $arrServices = Service::where('status', 1)->get();

        return view('admin.discount.coupon_add', compact('arrServices'));

    }

    /*
    * Store Discount Coupon
    */

    public function storeDiscountCoupon(Request $request){

    	$this->validate($request,[
            'coupon_name'	    => 'required',
            'coupon_code'		=> 'required',
            'start_date'		=> 'required',
            'end_date'          => 'required',
            'discount_percent'  => 'required',
            'upto'              => 'required',
            'min_price'         => 'required',
            'per_person'        => 'required',
            'max_person'        => 'required',
            'term_and_cond'		=> 'required',
        ]);

		try{

			DB::beginTransaction();

            #Discount Coupon
			$discountcoupon 					 = new DiscountCoupon;
            $discountcoupon->coupon_name         = $request->coupon_name;
            $discountcoupon->coupon_code         = $request->coupon_code;
			$discountcoupon->start_date			 = date('Y-m-d H:i:s', strtotime($request->start_date));
			$discountcoupon->end_date			 = date('Y-m-d H:i:s', strtotime($request->end_date));
            $discountcoupon->discount_percent    = $request->discount_percent;
            $discountcoupon->upto                = $request->upto;
            $discountcoupon->min_price           = $request->min_price;
            $discountcoupon->per_person          = $request->per_person;
            $discountcoupon->max_person          = $request->max_person;
            $discountcoupon->term_and_cond       = $request->term_and_cond;
			$discountcoupon->status				 = 1;
			$discountcoupon->save();

            #Discount Coupon on Services
            foreach($request->service as $service){

                $discountcouponservice              = new DiscountCouponService;
                $discountcouponservice->coupon_id   = $discountcoupon->id;
                $discountcouponservice->service_id  = $service;
                $discountcouponservice->save();

            }

			DB::commit();
            return redirect('admin/discount/coupon')->with('success', 'Discount coupon added successfully');
			
        }catch(\Exception $e){
        	DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }

    }


    /*
    * Discount Coupon Edit
    */

    public function editDiscountCoupon(Request $request, $id){

        $arrDiscountCoupon = DiscountCoupon::where('id', $id)->first();

        $arrServices = Service::where('status', 1)->get();

        return view('admin.discount.coupon_edit', compact('arrDiscountCoupon', 'arrServices'));

    }

    /*
    * Discount Coupon Update
    */

    public function updateDiscountCoupon(Request $request, $id){


        $this->validate($request,[
            'coupon_name'       => 'required',
            'coupon_code'       => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'discount_percent'  => 'required',
            'upto'              => 'required',
            'min_price'         => 'required',
            'per_person'        => 'required',
            'max_person'        => 'required',
            'term_and_cond'     => 'required',
        ]);

        try{

            DB::beginTransaction();

            $discountcoupon                      = DiscountCoupon::find($id);
            $discountcoupon->coupon_name         = $request->coupon_name;
            $discountcoupon->coupon_code         = $request->coupon_code;
            $discountcoupon->start_date          = date('Y-m-d H:i:s', strtotime($request->start_date));
            $discountcoupon->end_date            = date('Y-m-d H:i:s', strtotime($request->end_date));
            $discountcoupon->discount_percent    = $request->discount_percent;
            $discountcoupon->upto                = $request->upto;
            $discountcoupon->min_price           = $request->min_price;
            $discountcoupon->per_person          = $request->per_person;
            $discountcoupon->max_person          = $request->max_person;
            $discountcoupon->term_and_cond       = $request->term_and_cond;
            $discountcoupon->save();


            
            DiscountCouponService::where('coupon_id', $id)->delete();

            #Discount Coupon on Services
            foreach($request->service as $service){

                $discountcouponservice              = new DiscountCouponService;
                $discountcouponservice->coupon_id   = $discountcoupon->id;
                $discountcouponservice->service_id  = $service;
                $discountcouponservice->save();

            }

            DB::commit();
            return redirect('admin/discount/coupon')->with('success', 'Discount coupon updated successfully');
            
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }

    }

    /*
    * Discount Coupon Delete
    */

    public function deleteDiscountCoupon($id){

        try{
            DiscountCoupon::where('id', $id)->delete();
            DiscountCouponService::where('coupon_id', $id)->delete();
            return redirect()->back()->with('success', 'Discount coupon deleted successfully!');   
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
    }


    /*
    * Discount Offer
    */
    
    public function discountOffer(Request $request){

        $offerName = $request->get('offer_name');

        $arrDiscountOffer = DiscountOffer::select('discount_offers.*')
                                            ->where('status', 1);
                                            if($offerName){
                                                $arrDiscountOffer->where('offer_name', 'like', '%'.$offerName.'%');
                                            }
        $arrDiscountOffer = $arrDiscountOffer->paginate(10);
       
        return view('admin.discount.offer_list', compact('arrDiscountOffer'));
      
    }

    /*
    * Add Discount Offer
    */

    public function addDiscountOffer(){

        $arrServices = Service::where('status', 1)->get();

        return view('admin.discount.offer_add', compact('arrServices'));

    }

    /*
    * Store Discount Offer
    */

    public function storeDiscountOffer(Request $request){

        $this->validate($request,[
            'offer_name'       => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'discount_percent'  => 'required',
            'upto'              => 'required',
            'min_price'         => 'required',
            'per_person'        => 'required',
            'max_person'        => 'required',
            'term_and_cond'     => 'required',
        ]);

        try{

            DB::beginTransaction();

            #Discount Offer
            $discountoffer                      = new DiscountOffer;
            $discountoffer->coupon_name         = $request->offer_name;
            $discountoffer->start_date          = date('Y-m-d H:i:s', strtotime($request->start_date));
            $discountoffer->end_date            = date('Y-m-d H:i:s', strtotime($request->end_date));
            $discountoffer->discount_percent    = $request->discount_percent;
            $discountoffer->upto                = $request->upto;
            $discountoffer->min_price           = $request->min_price;
            $discountoffer->per_person          = $request->per_person;
            $discountoffer->max_person          = $request->max_person;
            $discountoffer->term_and_cond       = $request->term_and_cond;
            $discountoffer->status              = 1;
            $discountoffer->save();

            #Discount Offer on Services
            foreach($request->service as $service){

                $discountofferservice              = new DiscountOfferService;
                $discountofferservice->offer_id   = $discountoffer->id;
                $discountofferservice->service_id  = $service;
                $discountofferservice->save();

            }

            DB::commit();
            return redirect('admin/discount/offer')->with('success', 'Discount offer added successfully');
            
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }

    }


    /*
    * Discount Offer Edit
    */

    public function editDiscountOffer(Request $request, $id){

        $arrDiscountOffer = DiscountOffer::where('id', $id)->first();

        $arrServices = Service::where('status', 1)->get();

        return view('admin.discount.offer_edit', compact('arrDiscountOffer', 'arrServices'));

    }

    /*
    * Discount Offer Update
    */

    public function updateDiscountOffer(Request $request, $id){


        $this->validate($request,[
            'offer_name'       => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'discount_percent'  => 'required',
            'upto'              => 'required',
            'min_price'         => 'required',
            'per_person'        => 'required',
            'max_person'        => 'required',
            'term_and_cond'     => 'required',
        ]);

        try{

            DB::beginTransaction();

            $discountoffer                      = DiscountOffer::find($id);
            $discountoffer->offer_name          = $request->offer_name;
            $discountoffer->start_date          = date('Y-m-d H:i:s', strtotime($request->start_date));
            $discountoffer->end_date            = date('Y-m-d H:i:s', strtotime($request->end_date));
            $discountoffer->discount_percent    = $request->discount_percent;
            $discountoffer->upto                = $request->upto;
            $discountoffer->min_price           = $request->min_price;
            $discountoffer->per_person          = $request->per_person;
            $discountoffer->max_person          = $request->max_person;
            $discountoffer->term_and_cond       = $request->term_and_cond;
            $discountoffer->save();


            
            DiscountOfferService::where('offer_id', $id)->delete();

            #Discount Coupon on Services
            foreach($request->service as $service){

                $discountofferservice              = new DiscountOfferService;
                $discountofferservice->offer_id    = $discountoffer->id;
                $discountofferservice->service_id  = $service;
                $discountofferservice->save();

            }

            DB::commit();
            return redirect('admin/discount/offer')->with('success', 'Discount offer updated successfully');
            
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }

    }

    /*
    * Discount Offer Delete
    */

    public function deleteDiscountOffer($id){

        try{
            DiscountOffer::where('id', $id)->delete();
            DiscountOfferService::where('offer_id', $id)->delete();
            return redirect()->back()->with('success', 'Discount offer deleted successfully!');   
        }
        catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
    }


    /*
    * Helper Functions
    */

    public static function getServicesCoupon($coupon_id){

        $arrData = DiscountCouponService::select('service_name')
                                ->join('services', 'services.id', '=', 'discount_coupon_services.service_id')
                                ->where('coupon_id', $coupon_id)
                                ->get();

        $varServiceName = '';
        foreach($arrData as $data){
            $varServiceName .= $data->service_name.', ';

        }
        return $varServiceName;

    }

    public static function getServicesOffer($offer_id){

        $arrData = DiscountOfferService::select('service_name')
                                ->join('services', 'services.id', '=', 'discount_offer_services.service_id')
                                ->where('offer_id', $offer_id)
                                ->get();

        $varServiceName = '';
        foreach($arrData as $data){
            $varServiceName .= $data->service_name.', ';

        }
        return $varServiceName;

    }


    public static function getServicesID($id){


        $arrData = DiscountCouponService::where('coupon_id', $id)
                                ->pluck('service_id')
                                ->toArray();

        return $arrData;

    }

    public static function getServicesIDOffer($offer_name){

        $arrData = DiscountOffer::where('offer_name', $offer_name)
                                ->pluck('service_id')
                                ->toArray();

        return $arrData;

    }

}
