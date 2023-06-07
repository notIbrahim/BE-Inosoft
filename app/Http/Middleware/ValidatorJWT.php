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

class ValidatorJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     private $Keys;

     public function __construct()
     {
         $this->Keys = md5('Keycaps');
     }
     private function RetrieveKeys() 
     {
        return $this->Keys;
     }
    public function handle(Request $request, Closure $next): Response
    {
        $this->VerificationToken($request);
        return $next($request);
    }
    public function VerificationToken(Request $request)  
    {
        $Prefix = ["Bearer", ""];
        $values = $request->header("Authorization", 0);
        $values = explode("Bearer ", $values);
        $values = array_diff($values, $Prefix);
        $values = implode($values);
        $parser = new Parser(new JoseEncoder());
        $AccessKey = new ValidatorJWT;
        $Keys = $AccessKey->RetrieveKeys();
        $validator = new Validator();
        $token = $parser->parse($values);
        try {
            $validator->assert($token, new RelatedTo(md5($Keys)));
            $request->merge(['Message' => 'OK']);
            return;
        } 
        catch (RequiredConstraintsViolated $e) 
        {
            return response(400)->json([
                "Message" => $e->getMessage(),
            ]);
        }
   }
}
