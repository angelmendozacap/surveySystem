<?php

namespace App\Http\Controllers;

use App\OptionGroup;
use Illuminate\Http\Request;
use App\Http\Resources\OptionGroup as OptionGroupResource;
use App\Http\Requests\StoreOptionGroupRequest;
use Symfony\Component\HttpFoundation\Response;

class OptionGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = OptionGroup::all();
        return OptionGroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOptionGroupRequest $request)
    {
        $group = OptionGroup::create($request->all());
        return (new OptionGroupResource($group))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OptionGroup  $optionGroup
     * @return \Illuminate\Http\Response
     */
    public function show(OptionGroup $group)
    {
        return (new OptionGroupResource($group))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OptionGroup  $optionGroup
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOptionGroupRequest $request, OptionGroup $group)
    {
        $group->update($request->all());
        return (new OptionGroupResource($group))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OptionGroup  $optionGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OptionGroup $group)
    {
        $group->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }
}
