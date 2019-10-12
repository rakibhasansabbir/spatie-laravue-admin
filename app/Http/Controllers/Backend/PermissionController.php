<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Permission\PermissionRequest;
use App\Repository\Backend\PermissionRepository;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $repository;

    public function __construct(PermissionRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        // return Permission::all();
        return view('backend.permission.index');
    }
    public function indexApi(){
        return response()->json($this->repository->getAll());
    }
    public function store(PermissionRequest $request){
        if ($permission = $this->repository->store($request)) {
            return response()->json([
                'message' => 'Permission created successfully',
                'data' => $permission
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    public function update($id, PermissionRequest $request)
    {

        if ($permission = $this->repository->update($id, $request)) {
            return response()->json([
                'message' => 'Permission update successfully',
                'data' => $permission
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return response()->json([
                'message' => 'Permission deleted successfully',
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
