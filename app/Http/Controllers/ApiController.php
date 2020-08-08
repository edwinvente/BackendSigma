<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ApiController extends Controller
{
    public function index()
    {
        $actual = json_decode( file_get_contents('https://sigma-studios.s3-us-west-2.amazonaws.com/test/colombia.json'), true);
    
        $users = \DB::table('contacts')->get();

        $data = [
            'users' => $users,
            'departaments' => $actual
        ];

        return response()->json([
            'users' => $users,
            'departaments' => $actual
        ], 200); 
    }

    public function save(Request $request)
    {   
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        $status = false;

        $contact = new Contact();
        $contact->name = $params->name;
        $contact->email = $params->email;
        $contact->city = $params->city;
        $contact->state = $params->department;

        if ($contact->save()) {
            $status = true;
        }

        return response()->json($status, 200);
    }
}
