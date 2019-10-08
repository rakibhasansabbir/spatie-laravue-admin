<?php

namespace App\Http\Controllers\Backend;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Backend\RoleRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $role;

    public function __construct(RoleRepository $role){
        $this->role = $role;
    }

    public function index(Request $request){
        // $role = Role::create(['name' => 'admin']);
        // $permission = Permission::create(['name' => 'delete_admin']);
        // $role = Role::findById(1);
        // return $permission = Permission::findById(1);
        // return Role::with('permissions')->get();
        // return  $request;
        return $this->role->index($request);
    }
    public function create(){
        return $this->role->create();
    }
    public function store(Request $request){
        return $this->role->store($request);
    }
    public function edit($id){
        return $this->role->edit($id);
    }
    public function update(Request $request,$id){
        return $this->role->update($request,$id);
    }
    public function delete($id){
        return $this->role->delete($id);
    }
}
