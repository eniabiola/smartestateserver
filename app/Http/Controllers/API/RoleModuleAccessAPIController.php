<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\RoleModuleAccessStoreRequest;
use App\Http\Resources\ModuleAccessIndex;
use App\Http\Resources\RoleResource;
use App\Models\ModuleAccess;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleModuleAccessAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //This action is performed in the list of module_access
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleModuleAccessStoreRequest $request)
    {
        $module_access = $request->module_access;
//        return $roles;
        $role = Role::find($request->role);
        $role->moduleAccess()->sync($module_access);
        return $this->sendResponse(new RoleResource($role), 'Module Accesses for the selected role changed.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
