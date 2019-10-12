<?php
/**
 * Created by PhpStorm.
 * User: rakib
 * Date: 7/10/2019
 * Time: 2:31 AM
 */

namespace  App\Repository\Backend;


use DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRepository{

    public function model(){
        return Permission::class;
    }

    public function getAll(){
        return $this->model()::all();
    }

    public function store($request)
    {
        $role = $this->model()::create([
            'name' => $request->name,
        ]);
        // auth()->user()->assignRole($role);
        return $role;
    }

    public function update($id, $request)
    {
        $role = $this->model()::findOrFail($id);
        return $role->update($request->except('permissions'));
    }

    public function delete($id)
    {
        $role = $this->model()::findOrFail($id);

        return DB::transaction(function () use ($role) {
            $role->delete();
            return true;
        });
    }



}
