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
    private $repository;

    public function __construct(RoleRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        return view('backend.role.index');
    }
    public function indexApi(){
        return response()->json($this->repository->getAll());
    }

}
