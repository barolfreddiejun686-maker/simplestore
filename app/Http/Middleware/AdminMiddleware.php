<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class AdminMiddleware
{
public function handle(Request $request, Closure $next): Response
{
// Check if user is logged in and is an admin
if (!Auth::check() || Auth::user()->role !== 'admin') {
    return redirect()->route('admin.dashboard');
}
return $next($request);
}
}