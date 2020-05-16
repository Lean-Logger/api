<?php

namespace App\Http\Middleware;

use App\Domain\User\LoginTokenRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Presentation\Http\Response\UnauthorizedResponse;
use Closure;
use Illuminate\Http\Request;

class LoginTokenMiddleware
{
    public const AUTH_HEADER_NAME = 'X-Login-Token';

    private $userRepository;

    private $loginTokenRepository;

    public function __construct(UserRepositoryInterface $userRepository, LoginTokenRepositoryInterface $loginTokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->loginTokenRepository = $loginTokenRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $loginTokenHeader = $request->header(self::AUTH_HEADER_NAME, null);

        if (!$loginTokenHeader) {
            return new UnauthorizedResponse();
        }

        $loginToken = $this->loginTokenRepository->findOneByToken($loginTokenHeader);

        if (!$loginToken) {
            return new UnauthorizedResponse();
        }

        $user = $this->userRepository->findOneById($loginToken->getUserId());

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
