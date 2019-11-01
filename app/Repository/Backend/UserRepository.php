<?php

/**
 * Created by PhpStorm.
 * User: rakib
 * Date: 7/10/2019
 * Time: 2:31 AM
 */

namespace App\Repository\Backend;


use DB;
use App\User;

class UserRepository
{

    public function model()
    {
        return User::class;
    }

    public function getAll()
    {
        $data = $this->model()::with('roles')->get();

        //remove pivot attribute
        foreach ($data as $d) {
            foreach ($d->roles as $role) {
                unset($role['pivot']);
            }
        }
        return $data;
    }

    public function store($request)
    {
        //
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        $data = $this->model()::with('roles')->where('id', $id)->first();
        $data->name = $request->name;
        $data->save();
        if ($request->filled('roles')) {
            $data->syncRoles($request->roles);
        }
        DB::commit();
        return true;
    }

    public function delete($id)
    {
        $data = $this->model()::findOrFail($id);

        return DB::transaction(function () use ($data) {
            $data->delete();
            return true;
        });
    }


}
