<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Lcobucci\JWT\Token\Parser;
use Illuminate\Support\Facades\Redis;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Symfony\Component\HttpFoundation\Response;

class AuthJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $ReceivedToken = self::GenerateToken($request);
        $request->merge([
            'Token' => $ReceivedToken
        ]);
        return $next($request);
    }

    public function GenerateToken(Request $request) : String 
    {
        $AlgoMethod = new Sha256();
        $ParamData = $request->query() ? array($request->query('Name'), $request->query('Password')) : null;
        $PassKey = md5('Keycaps');
        $Tokens = (new Builder(new JoseEncoder, ChainedFormatter::default()))->
        issuedBy('http://localhost:8083')->identifiedBy('Keycaps')->relatedTo(md5($PassKey))->
        withClaim('Data', $ParamData)->getToken($AlgoMethod, InMemory::plainText($PassKey));
        $SendToken = $Tokens->toString();
        // $request->merge(['Tokens' => $SendToken]);
        return $SendToken;
    }
}
