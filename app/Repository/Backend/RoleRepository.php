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
        $data = $this->model()::with('permissions')->get();

        //remove pivot attribute
        foreach ($data as $d) {
            foreach ($d->permissions as $permission) {
                unset($permission['pivot']);
            }
        }
        return $data;
    }

    public function getList(){
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
        DB::beginTransaction();
        $role = $this->model()::with('permissions')->where('id',$id)->first();
        $role->name = $request->name;
        $role->save();
        if($request->filled('permissions')){
            $role->syncPermissions($request->permissions);
        }
        DB::commit();
        return true;
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
