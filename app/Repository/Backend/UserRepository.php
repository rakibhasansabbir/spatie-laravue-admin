<?php

/**
 * Created by PhpStorm.
 * User: rakib
 * Date: 7/10/2019
 * Time: 2:31 AM
 */

namespace  App\Repository\Backend;


use DB;
use App\User;

class UserRepository{

    public function model(){
        return User::class;
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
