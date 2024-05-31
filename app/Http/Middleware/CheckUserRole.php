<?php

namespace App\Http\Middleware;

use App\Models\Datotekaobracunskihkoeficijenata;
use App\Modules\Obracunzarada\Consts\UserRoles;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckUserRole
{

    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface)
    {
    }

    public const POENTER_ROUTES = [
        'login',
        'obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_poenter',
        'obracunzarada/datotekaobracunskihkoeficijenata/update',
        'obracunzarada/datotekaobracunskihkoeficijenata/permissionStatusUpdate'
    ];

    public function handle($request, Closure $next)
    {

        $response = $next($request);
        $path = $request->path();
        $parts = explode('/', $path);
        $requiredModule = $parts[0];

        if (Auth::user() !== null) {
            $userData = Auth::user()->load(['permission']);
            $permissions = $userData->permission;

            $isPoenter = UserRoles::POENTER == $permissions->role_id;
            $notAllowed = UserRoles::NONE==$permissions->role_id;


            $poenterRoutes = in_array($request->path(), self::POENTER_ROUTES);
            if($notAllowed && $request->path()!=='nopermission'){

                return redirect(route('noPermission'));

            } else if ($isPoenter) {

                if (!$poenterRoutes) {

                    $activeMonth = $this->datotekaobracunskihkoeficijenataInterface->where('status', Datotekaobracunskihkoeficijenata::AKTUELAN)->first();
                    return redirect(route('datotekaobracunskihkoeficijenata.odobravanje_poenter', ['month_id' => $activeMonth->id]));

                }
            } else {
                // Sve osim poentera// provera modula
                if ($requiredModule == 'osnovnipodaci' && $permissions->osnovni_podaci !==1) {

                    return redirect(route('noPermission'));

                } elseif ($requiredModule == 'obracunzarada' && $permissions->obracun_zarada !==1) {

                    return redirect(route('noPermission'));
                }elseif ($requiredModule == 'kadrovskaevidencija' && $permissions->kadrovska_evidencija !==1) {

                    return redirect(route('noPermission'));
                }
            }

                if($request->path()=='dashboard'){
                    return redirect(route('datotekaobracunskihkoeficijenata.create'));

                }
        }
        return $response;
    }
}
//                if($request->path()=='dashboard'){
//                    return redirect(route('datotekaobracunskihkoeficijenata.create'));
//
//                }else

