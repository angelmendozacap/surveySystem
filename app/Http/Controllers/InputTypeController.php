<?php

namespace App\Http\Controllers;

use App\InputType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\InputType as InputTypeResource;

class InputTypeController extends Controller
{
    public function index()
    {
        $inputTypes = InputType::all();

        return InputTypeResource::collection($inputTypes);
    }

    public function store()
    {
        $data = request()->validate([
            'type' => 'required|string',
            'display_name' => 'required|string'
        ]);

        $inputType = InputType::create($data);

        return (new InputTypeResource($inputType))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(InputType $inputType)
    {
        $inputType->delete();
        return response([], Response::HTTP_OK);
    }
}
