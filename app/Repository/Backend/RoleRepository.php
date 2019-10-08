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

    public function index($request){
        $role = Role::with('permissions')->get();
        return view('backend.role.index',compact('role'));
    }
    public function create(){
        storeLog('role create','','');
        $permission = Permission::all();
        return view('backend.role.create',compact('permission'));
    }
    public function store($request){
        $store_log = storeLog($request->all(),'','');
        try{
            DB::beginTransaction();
            $role = new Role();
            $role->name = $request->title;
            $role->display_name = $request->display_title;
            $role->save();
            $role->attachPermissions($request->permission);
            storeLog('',json_encode($role),$store_log);
            DB::commit();
            Session::flash('successMsg','role added');
            return redirect()->route('role.index');
        }catch(\Exception $e){
            storeLog('',json_encode($e),$store_log);
            DB::rollback();
            Session::flash('errorMsg','role failed to add');
            return back();
        }
    }
    public function edit($id){
        storeLog('role create','','');
        $permission = Permission::all();
        $role = Role::with('getPermissions')->where('id',$id)->first();
        return view('backend.role.edit',compact('permission','role'));
    }
    public function update($request,$id){
        $store_log = storeLog($request->all(),'','');
        try{
            DB::beginTransaction();
            $role = Role::with('getPermissions')->where('id',$id)->first();
            $role->name = $request->title;
            $role->display_name = $request->display_title;
            $role->save();
            if($request->filled('permission')){
                $role->detachPermissions();
                $role->attachPermissions($request->permission);
            }
            storeLog('',json_encode($role),$store_log);
            DB::commit();
            Session::flash('successMsg','role updated');
            return redirect()->route('role.index');
        }catch(\Exception $e){
            storeLog('',json_encode($e),$store_log);
            DB::rollback();
            Session::flash('errorMsg','role failed to update');
            return back();
        }
    }
    public function delete($id){
        storeLog('delete role','','');
        $role = Role::find($id)->delete();
        Session::flash('successMsg','role deleted');
        return back();
    }

}
