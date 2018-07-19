<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Division;

class DivisionController extends Controller
{

    public function showDivision()
    {
        $divisions = DB::table('divisions')->paginate(3);
        return view('division', ['divisions' => $divisions]);
    }

    public function create()
    {
        return view('createDivision');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|unique:divisions',
        ];
        $messages = [
            'name.required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'name.unique' => 'Phòng đã tồn tại',
        ];
        $request->validate($rules, $messages);
        
        $division = Division::create($request->all());

        if ($division->save()) {
            return redirect()->route('showDivision');
        }
    }

    public function edit($id)
    {
        $division = Division::find($id);
        return view('editDivision', compact('division'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function update(Request $request, $id)
    {
        $division = Division::find($id);
        $rules = [
            'name' => 'required|string',
        ];
        $messages = [
            'name.required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'name.unique' => 'Phòng đã tồn tại',
        ];
        if ($division->name != $request->get('name')) {
            $rules['name'] = 'required|string|unique:divisions';
        }
        $request->validate($rules, $messages);

        $division->name = $request->name;

        if ($division->save()) {
            return redirect()->route('showDivision');
        }
    }

    public function destroy($id)
    {
        Division::find($id)->delete();
        return redirect()->route('showDivision');
    }

}
