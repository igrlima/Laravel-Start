<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Facades\Artisan;

class UsersController extends Controller
{

    public function index ()
    {
        $users = DB::table('users as u')
        ->leftjoin('model_has_roles as mhr','u.id','model_id')
        ->leftjoin('roles as r','mhr.role_id','r.id')
        ->select('u.id','u.username','u.name','u.created_at')
        ->selectraw('group_concat(r.name order by r.name) roles')
        ->groupby('u.id','u.username','u.name','u.created_at')
        ->get();


        return view('users.users',compact('users'));
    }

    public function destroy (Request $request)
    {
        try {
            User::destroy($request->id);
            Flash("Usuário Excluido com sucesso!")->success();
        } catch (\Exception $e) {
            Flash("Não é possivel excluir o usuário de ID ".$request->id."!<br>Existem dados associados a ele no sistema!")->error();
        }

        return back();
    }

    public function edit (Request $request)
    {
        $user = User::find($request->id);
        $roles = Role::all();
        $roles_user = $user->getRoleNames();

        if($request->method() == 'GET')
        {
            return view('users.users_edit',compact('user','roles','roles_user'));
        }

        try {
            $user->username = strtolower($request->username);
            $user->name = $request->name;

            if(!empty($request->password))
            {
                $user->password = Hash::make($request->password);
            }

            $user->syncRoles($request->roles);
            $user->save();

            Artisan::call('cache:clear');
            // Artisan::call('config:cache');

            Flash("Informações alteradas com sucesso!")->success();
            return redirect()->route('users');
        } catch (\Exception $e) {
            if(strstr($e->getMessage(),'users_username_unique'))
            {
                Flash("Já Existe um usuário com essas informações!")->error();
                $request->flash();
                return back();
            }
        }
    }

    public function create (Request $request)
    {
        if($request->method() == 'GET')
        {
            return view('users.users_create');
        }

        DB::beginTransaction();

        try
        {
            DB::table('users')->insert([
                'name' => $request->name,
                'username' => strtolower($request->username),
                'password' => Hash::make($request->password),
                'created_at' => now()
            ]);

            DB::commit();
        }
        Catch(\Exception $e)
        {
            DB::rollback();
            $request->flash();
            if(strstr($e->getMessage(),'Duplicate'))
            {
                Flash("Já existe um usuário com essas informações!")->warning();
                return back();
            }
            else
            {
                Flash("Ocorreu um erro! <br> ".$e->getMessage())->error();
                return back();
            }
        }

        Flash("Nome: ".$request->name.'<br> Usuário: '.$request->username."<br><br> Criado com sucesso!")->success();

        return redirect()->route('users');
    }
}
