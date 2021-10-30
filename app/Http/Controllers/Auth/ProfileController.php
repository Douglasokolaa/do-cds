<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfile;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['permissions', 'roles', 'profile']);
        return $this->success($user);
    }

    public function update(UpdateProfile $request): JsonResponse
    {
        $user = $this->userRepository->updateUser($request->user(), $request->safe());
        return $this->success($user, 'Profile Updated');
    }

    public function projectProgress(): array
    {
        return $this->userRepository->getUserGmbProgress(auth()->user());
    }
}
