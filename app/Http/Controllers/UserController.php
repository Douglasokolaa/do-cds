<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\State;
use App\Models\Training;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use App\Repositories\UserRepository;
use App\Services\ImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->authorizeResource(User::class);
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        return $this->success($this->userRepository->getUsers($request->all()));
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->createAccount($request->all());
        return $this->success($user, 'User Created', 201);
    }

    public function show(User $user): JsonResponse
    {
        $user = $this->userRepository->adminGetUser($user);
        return $this->success($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->userRepository->updateUser($user, $request->safe());
        return $this->success($user);
    }

    public function recordAttendance(User $user, Training $training): JsonResponse
    {
        $this->authorize('update', $user);
        $this->authorize('update', $training);

        $attendanceRepository = new AttendanceRepository();
        $attendanceRepository->recordAttendance($training, $user);
        return $this->success();
    }

    public function import(State $state, Request $request): JsonResponse
    {
        $this->authorize('import', User::class);

        $request->validate(['file' => ['file', 'max:50000', 'mimes:csv']]);
        ImportService::importUsers($state, $request);

        return $this->success([], 'Import Queued');
    }
}
