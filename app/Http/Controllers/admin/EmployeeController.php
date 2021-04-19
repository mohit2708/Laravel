<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Country;
use DB;

class EmployeeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
	{			
		$employee = Employee::all();		
		return view('admin.employee.index', compact('employee'));
	}

	/*
	 * Employee List Add
	 */

    public function add(Request $request)
	{	
		$countries = Country::all();	
		return view('admin.employee.add', compact('countries'));
	}

	/*
	 * Employee Store Function
	 */
	
    public function store(Request $request){
	
        $this->validate($request,[
            'fname'	=> 'required',
            'lname'	=> 'required',
            'email'	=> 'required',
            'pnumber'	=> 'required',
        ],[
        	'fname.required' => 'Enter your First Name',
        	'lname.required' => 'Enter your Last Name',
        	'email.required' => 'Enter your Email',
        	'pnumber.required' => 'Enter your Phone Number',

        ]);
		
		try{
			
			$employee 				= new Employee;
			$employee->f_name 		= $request->fname;
			$employee->l_name 		= $request->lname;
			$employee->email		= $request->email;
			$employee->phone_number	= $request->pnumber;
			$employee->save();
			
            return redirect('admin/employee')->with('success', 'Employee added successfully');
			
       }catch(\Exception $e){
           return redirect()->back()->with('error', 'Error occurs! Please try again!');
            
        }
    }

    public function edit($id){
		$dataEmployee = Employee::where('id', $id)->first();
		return view('admin.employee.edit', compact('dataEmployee'));	
	}

	public function update(Request $request, $id){        
            // $this->validate($request,[
            //     'policy_name'  => 'required',
            // ]);

            try{
                
                DB::beginTransaction();

                $employee                = Employee::find($id);
                $employee->f_name 		= $request->fname;
				$employee->l_name 		= $request->lname;
				$employee->email		= $request->email;
				$employee->phone_number	= $request->pnumber;
                $employee->save();
             DB::commit();
            return redirect('admin/employee')->with('success', 'Employee updated successfully');

            }catch(\Exception $e){
                 DB::rollback();
                return redirect()->back()->with('error', 'Error occurs! Please try again!');
            }
        }

    /*
	 *	Employee Delete Function
     */

    public function delete($id){			
		try{
			Employee::where('id', $id)->delete();	
			return redirect('admin/employee')->with('success', 'Employee deleted successfully!');	
		}
		catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurs! Please try again!');
        }
	}
	
}
