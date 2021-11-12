<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\RoleModuleAccessStoreRequest;
use App\Http\Resources\ModuleAccessIndex;
use App\Models\ModuleAccess;
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
        $roles = $request->roles;
//        return $roles;
        $moduleAccess = ModuleAccess::find($request->module_access);
        $moduleAccess->roles()->sync($roles);
        return $this->sendResponse(new ModuleAccessIndex($moduleAccess->toArray()), 'Module Access for various selected roles changed.');
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
