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

class RoleRepository{

    public function model(){
        return Role::class;
    }

    public function getAll(){
        return $this->model()::with('permissions')->get();
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

        $permissionIds = [];
        if(count($request->permissions)){
            foreach ($request->permissions as $key => $value) {
                $permissionIds[$key] = $value->id;
            }
            $role->givePermissionTo( array_unique($permissionIds));
        }
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
