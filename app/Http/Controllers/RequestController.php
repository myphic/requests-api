<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as Req;
use Illuminate\Http\Response;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return response(Req::orderBy('status')->get()->toJson(), Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        Req::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'message' => $request->post('message'),
        ]);
        return response()->json([
            "message" => "Request added."
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (Req::where('id', $id)->exists())
        {
            if (!is_null($request->post('comment')))
            {
                $req = Req::find($id);
                $req->comment = is_null($request->post('comment')) ? $req->comment : $request->post('comment');
                $req->status = 'Resolved';
                $req->save();
                return response()->json([
                    "message" => "Request updated."
                ]);
            }
            else
            {
                return response()->json([
                    "message" => "The comment should not be empty."
                ], 400);
            }
        }
        else
        {
            return response()->json([
                "message" => "Request not Found."
            ], 404);
        }
    }

}
