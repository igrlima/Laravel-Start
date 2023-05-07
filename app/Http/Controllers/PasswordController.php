<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index ()
    {
        return view('password');
    }

    public function update (Request $request)
    {
        $user = User::find(1);

        if (!Hash::check($request->old, $user->password)) {
            Flash("Senha digitada não confere com a atual!")->error();
            $request->flashExcept(['old']);
            return back();
        }

        if($request->new <> $request->new2)
        {
            Flash("Confirmação de nova senha não confere!")->error();
            $request->flashExcept(['new2']);
            return back();
        }

        $user->password = Hash::make($request->new);
        $user->save();

        Flash("Senha alterada com sucesso!")->success();
        return redirect()->route('dashboard');
    }
}
