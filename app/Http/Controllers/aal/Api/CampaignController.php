<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndustryType;
use App\Models\Campaign;


class CampaignController extends Controller
{
    
    /**
     * getCampaignList
     *
     * @param  mixed $request
     * @return void
     */
    public function getCampaignList(Request $request){
        try{
            $campaignData = Campaign::orderBy('id','desc')->get();
            return response()->json([
                'success' => True,
                'message' => "Campaign List get successfully",
                'data' => $campaignData,
                'status' => 200
            ],200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => False,
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }

    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request) {
        try{
            $data = $request->all();

            $validator = Validator::make($request->all(), [ 
                'industry_type'          => 'required',
            ]);
        
            if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }

            $Campaign                     = new Campaign;
            $Campaign->industry_type      = $data['industry_type'];
            $Campaign->lead_type          = $data['lead_type'];
            $Campaign->quality_type       = $data['quality_type'];
            $Campaign->area_type          = $data['area_type'];
            $Campaign->states             = $data['states'];
            $Campaign->nation             = $data['nation'];
            $Campaign->is_operating_hours = $data['is_operating_hours'];
            $Campaign->from_time          = $data['from_time'];
            $Campaign->to_time            = $data['to_time'];
            $Campaign->from_day           = $data['from_day'];
            $Campaign->available_at       = $data['available_at'];
            $Campaign->to_day             = $data['to_day'];
            // $Campaign->name               = $data['name'];
            $Campaign->email              = $data['email'];
            $Campaign->phone              = $data['phone'];
            $Campaign->quantity           = $data['quantity'];
            $Campaign->qty_type           = $data['qty_type'];
            // $Campaign->payment_status     = $data['payment_status'];
            // $Campaign->status             = $data['status'];            
            $Campaign->save();
            if($campaign->id)
            {
                $insertFilterResponse = $this->createUpdateFilterSet($request->all());
            }

            $message = "Campaign Create Successfully!!";

        }catch(\Throwable $e){
            $message = "Oops Somthing Went Wrong!";
            return response()->json([
                'success' => False,
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
        return response()->json([
            'success' => True,
            'message' => $message,
            'status' => 200
        ],200);
    }


    /**
     * Update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request) {
        try{
            $data = $request->all();
            $validator = Validator::make($request->all(), [ 
                'campaign_id'          => 'required',
            ]);
        
            if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }
            $campaign=Campaign::find($request->input('campaign_id'));
            $campaign->lead_type          = $request->input('lead_type') ? $request->input('lead_type') : $campaign->lead_type;
            $campaign->industry_type      = $request->input('industry_type')  ? $request->input('industry_type') : $campaign->industry_type;
            $campaign->quality_type       = $request->input('quality_type') ? $request->input('quality_type') : $campaign->quality_type;
            $campaign->area_type          = $request->input('area_type') ? $request->input('area_type') : $campaign->area_type;
            $campaign->states             = $request->input('states') ? $request->input('states') : $campaign->states;
            $campaign->nation             = $request->input('nation') ? $request->input('nation') : $campaign->nation;
            $campaign->is_operating_hours = $request->input('is_operating_hours') ? $request->input('is_operating_hours') : $campaign->is_operating_hours;
            $campaign->from_time          = $request->input('from_time') ? $request->input('from_time') : $campaign->from_time;
            $campaign->to_time            = $request->input('to_time') ? $request->input('to_time') : $campaign->to_time;
            $campaign->from_day           = $request->input('from_day') ? $request->input('from_day') : $campaign->from_day;
            $campaign->available_at       = $request->input('available_at') ? $request->input('available_at') : $campaign->available_at;
            $campaign->to_day             = $request->input('to_day') ? $request->input('to_day') : $campaign->to_day;
            $campaign->email              = $request->input('email') ? $request->input('email') : $campaign->email;
            $campaign->phone              = $request->input('phone') ? $request->input('phone') : $campaign->phone;
            $campaign->quantity           = $request->input('quantity') ? $request->input('quantity') : $campaign->quantity;
            $campaign->qty_type           = $request->input('qty_type') ? $request->input('qty_type') : $campaign->qty_type;
            $campaign->status             = $request->input('status') ? $request->input('status') : $campaign->status;  
            // $campaign->payment_status     = $data['payment_status'];
                      
            $campaign->update();
            $message = "Campaign Update Successfully!!";

        }catch(\Throwable $e){
            $message = "Oops Somthing Went Wrong!";
            return response()->json([
                'success' => False,
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
        return response()->json([
            'success' => True,
            'message' => $message,
            'status' => 200
        ],200);
    }


    /**
     * Show
     *
     * @param  mixed $request
     * @return void
     */
    public function show(Request $request) {
        $validator = Validator::make($request->all(), [ 
            'campaign_id'          => 'required|exists:campaigns,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $campaign_id = $request->campaign_id;
            $campaign=Campaign::findOrFail($campaign_id);
            if($campaign){
                return response()->json([
                    'success' => True,
                    'campaignData' => $campaign,
                    'status' => 200
                ],200);
            }
        }catch(\Exception $e){
            return response()->json([
                'success' => False,
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }

    public function destroy(Request $request) {
        try{
            $campaign = Campaign::findOrFail($request->campaign_id);
            $result = $campaign->delete();
            if($result){
                return response()->json([
                    'success' => True,
                    'message' => "Campaign has been deleted",
                    'status' => 200
                ],200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => False,
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }

    public function industryTypes(Request $request) {
        try{
            $industryTypeData = IndustryType::get();
            return response()->json([
                'success' => True,
                'message' => "IndustryType List get successfully",
                'data' => $industryTypeData,
                'status' => 200
            ],200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => False,
                'message' => $e->getMessage(),
                'status' => 500
            ],500);
        }
    }
      
    /**
     * createUpdateFilterSet
     *
     * @param  mixed $data
     * @return void
     */
    public function createUpdateFilterSet($data)
    {
        try
        {
            $reqParamArray = array();
            $reqParamArray['Key'] = 'afe24aebdcfda2f47c5926392436ba240b13ce78fbfa4393cfba6afd1f155d9f';
            $reqParamArray['API_Action'] = "insertUpdateFilterSet";
            $reqParamArray['Mode'] = $request->mode_type;
            $reqParamArray['Format'] = "json";
            $reqParamArray['TYPE'] = $request->lead_type;
            $reqParamArray['Partner_ID'] = $request->partner_id;
            // $reqParamArray['Filter_Set_ID'] = $request->filter_set_id;
            $reqParamArray['Filter_Set_Name'] = $request->filter_set_name;
            $reqParamArray['Filter_Set_Price'] = $request->filter_set_price;
            $reqParamArray['Partner_Ring_To'] = $request->partner_ring_to;
            $reqParamArray['Max_Concurrent_Calls'] = $request->max_concurrent_calls;
            $reqParamArray['Per_Minute_Fee'] = $request->per_minute_fee;
            $reqParamArray['Record_Phone_Call'] = $request->record_phone_call;
            $reqParamArray['Default_Phone_Routing'] = $request->default_phone_routing;
            $reqParamArray['Successful_Minutes'] = $request->successful_minutes;
            $reqParamArray['Ring_Timeout'] = $request->ring_timeout;
            $reqParamArray['Accepted_Sources'] = $request->accepted_sources;
            $reqParamArray['Match_Priority'] = $request->match_priority;
            $reqParamArray['Accept_Only_Reprocessed_Leads'] = $request->accept_only_reprocessed_leads;
            $reqParamArray['Daily_Limit'] = $request->daily_limit;
            $reqParamArray['Weekly_Limit'] = $request->weekly_limit;
            $reqParamArray['Monthly_Limit'] = $request->monthly_limit;
            $reqParamArray['Origin_Phone_Area_Code'] = $request->origin_phone_area_code;
            $reqParamArray['Default_Phone_Routing'] = $request->default_phone_routing;


            $params['Request'] = $reqParamArray;
            $data = json_encode($params);

            $client = new Client([
                'headers' => ['Content-Type' => 'application/json']
            ]);
            $response = $client->post('https://askarileads.leadportal.com/apiJSON.php', 
                    ['body' => $data]
            );
            $response = $response ? (json_decode($response->getBody(), true)) : "No Data Available";

            return response()->json([
                'success' => True,
                'message' => "Insert/Update filter set successfully",
                'data' => $response['response'],
                'status' => 200
            ],200);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

}

