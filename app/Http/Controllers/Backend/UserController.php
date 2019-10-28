<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Role\UserRequest;
use App\Repository\Backend\UserRepository;
use App\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('backend.user.index');
    }

    public function indexApi()
    {
        return response()->json($this->repository->getAll());
    }

    public function store(UserRequest $request)
    {
        if ($role = $this->repository->store($request)) {
            return response()->json([
                'message' => 'User created successfully',
                'data' => $role
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(Request $request, $id)
    {
        if ($role = $this->repository->update($id, $request)) {
            return response()->json([
                'message' => 'User permissions update successfully',
                'data' => $role
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return response()->json([
                'message' => 'User deleted successfully',
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
