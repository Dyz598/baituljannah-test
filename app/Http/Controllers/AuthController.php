<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class AuthController extends Controller
{
    public function __construct(
        protected readonly UserRepository $userRepository,
    ) {}

    public function login(LoginFormRequest $request): JsonResponse
    {
        $payload = $request->validated();

        /** @var User $user */
        $user = $this->userRepository->findOneByEmail($payload['email']);

        if (null === $user || !Hash::check($payload['password'], $user->password)) {
            return response()->json(
                ['message' => 'Email/Password is invalid.'],
                401
            );
        }

        return response()->json(
            ['token' => $user->createToken('auth')->plainTextToken],
        );
    }
}
