<?php
namespace App\Externals\Sabreapi\Rest;

use App\Externals\Sabreapi\Rest\Auth;

class TokenHolder {

    private static $token = null;
    
    private static $expirationDate = 0;
    
    public static function getToken() {
        
        if (TokenHolder::$token == null || time() > TokenHolder::$expirationDate) {
            $authCall = new Auth();
            TokenHolder::$token = $authCall->callForToken();
            TokenHolder::$expirationDate = time() + TokenHolder::$token->expires_in;
            
        }
        return TokenHolder::$token;
    }
}

