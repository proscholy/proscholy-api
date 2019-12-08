<?php
namespace App\Firebase;

use Firebase\Auth\Token\Verifier;
use App\PublicModels\PublicUser;

class Guard
{
    protected $verifier;
    public function __construct(Verifier $verifier)
    {
        $this->verifier = $verifier;
    }

    public function public_user($request)
    {
        $token = $request->bearerToken();
        try {
            $token = $this->verifier->verifyIdToken($token);

            return PublicUser::getPublicUserFromClaims($token->getClaims());
        }
        catch (\Exception $e) {
            return;
        }
    }
}
