<?php

namespace App\Http\Controllers;
use Validator;
use App\Booker;
use Illuminate\Http\Request;

class BookerController extends Controller
{
    public function store(Request $request)
    {   
        $rules = array(
            'booker' => 'required|unique:bookers,booker_name,NULL,id,deleted_at,NULL',
        );
        $customMessages = [
            'required' => 'Please enter a role',
            'unique' => 'This booker already exist'
        ];

        $validator = Validator::make($request->all(),$rules,$customMessages);

        if ($validator->passes()) {
            $booker = new Booker;
            $booker->booker_name = $request->input('booker');
            $booker->save();
            return response()->json($booker);
			
        }
        return response()->json(['error'=>$validator->errors()]);
    }

    public function deleteCheckedBooker(Request $request)
    {
        $ids = $request->ids;
        $booker = Booker::select('booker_name')->whereIn('id',$ids)->get();
        Booker::whereIn('id',$ids)->delete();
        return response()->json(["success"=>"Booker Deleted Successfully"]);
    }


    

    
}
