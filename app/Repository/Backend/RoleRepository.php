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



}
