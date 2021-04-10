<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class DatabaseController extends AppBaseController
{
    public function index(Request $request)
    {
        $data = json_decode($request->data);
        foreach ($data as $school) {
            Education::create([
                'school_name' => $school->school_name,
                'address' => $school->address,
                'tel' => $school->tel,
                'fax' => $school->fax,
                'notes' => $school->notes,
            ]);
        }
        return $this->sendRespondSuccess('done', '123');
    }

    public function show()
    {
        $data = Education::all()->count();

        return $data;
    }

    public function store(Education $education)
    {


        return $education;
    }

    public function truncate()
    {
        $data = Education::truncate();
        // $data->truncate();
        return true;
    }
}
