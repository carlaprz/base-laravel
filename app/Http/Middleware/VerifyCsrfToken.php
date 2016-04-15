<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	protected $except = [
		'payment/tpv/response',
		'payment/tpv/ok',
		'payment/tpv/ko',
		'payment/paypal/response',
		'payment/paypal/ko',
		'payment/paypal/ok',
	];

	public function handle( $request, Closure $next )
	{
		if ($this->isReading($request) || $this->excludedRoutes($request) || $this->tokensMatch($request)) {
			return $this->addCookieToResponse($request, $next($request));
		}

		throw new TokenMismatchException;
	}

	protected function excludedRoutes( $request )
	{
		$routes = $this->except;

		foreach ($routes as $route)
			if ($request->is($route))
				return true;

		return false;
	}

}
