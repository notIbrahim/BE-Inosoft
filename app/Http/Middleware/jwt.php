<?php

namespace App\Http\Middleware;

use Closure;
use Dotenv\Parser\Value;
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
use Lcobucci\JWT\UnencryptedToken;
use Symfony\Component\HttpFoundation\Response;

class jwt extends Middleware
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

    private function RetrieveKeys ()
    {
        return $this->Keys;
    }

    public function GenerateToken(Request $request, Closure $next): Response 
    {
        $AlgoMethod = new Sha256();
        $ParamData = $request->query() ? array($request->query('Name'), $request->query('Password')) : null;
        $AccessKey = new jwt;
        $PassKey = $AccessKey->RetrieveKeys();
        $Tokens = (new Builder(new JoseEncoder, ChainedFormatter::default()))->
        issuedBy('http://localhost:8083')->identifiedBy('Keycaps')->relatedTo(md5($PassKey))->
        withClaim('Data', $ParamData)->getToken($AlgoMethod, InMemory::plainText($PassKey));
        $SendToken = $Tokens->toString();
        $request->merge(['Tokens' => $SendToken]);
        return $next($request);
    }

    public function VerificationToken(Request $request, Closure $next): Response 
    {
        $Prefix = ["Bearer", ""];
        $values = $request->header("Authorization", 0);
        $values = explode("Bearer ", $values);
        $values = array_diff($values, $Prefix);
        $values = implode($values);
        $parser = new Parser(new JoseEncoder());
        // $validator = new Validator();
        // if ($validator->validate($token, new RelatedTo(md5('Laravel'))))
        // {
        //     return true;
        // }

        $validator = new Validator();
        $token = $parser->parse($values);
        try {
            $validator->assert($token, new RelatedTo(md5($this->Keys)));
            $request->merge(['Message' => 'OK']);
            return $next($request);
        } 
        catch (RequiredConstraintsViolated $e) 
        {
            return response(400)->json([
                "Message" => $e->getMessage(),
            ]);
        }

        // if ($validator->assert($token, new RelatedTo(md5($this->Keys))))
        // {
        //     return $next($request);
        // } 
        // try {
        //     $token = $parser->parse($values);
        //     $validator = new Validator();
        //     assert($token instanceof UnencryptedToken);
        //     $validator->assert($token, new RelatedTo($token->claims()->get('sub')));
        // } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
        //     echo 'Oh no, an error: ' . $e->getMessage();
        // }
    } 
}


