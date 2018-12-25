<?php

/* Create by Xenial */

namespace app\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('cabinet');
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    public function index()
    {
        # Проверяем через Фасад Auth::user() - Root или Admin
        if(Auth::user()->root == 1 && Auth::user()->isAdmin == 1){

            # Redirect to route('essences')
            return redirect(route('essences'))->with('success', trans('messages.cabinet.welcomeRoot'));
        }

        elseif(Auth::user()->root == 0 && Auth::user()->isAdmin == 1){

            # Redirect to route('essences')
            return redirect(route('essences'))->with('success', trans('messages.cabinet.welcomeAdmin'));
        }

        else {
            # Redirect to route('essences')
            return redirect(route('essences'))->with('success', trans('messages.cabinet.welcomeUser'));
        }
    }

    # :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}