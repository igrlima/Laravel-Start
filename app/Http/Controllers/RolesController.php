<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Artisan;

class RolesController extends Controller
{
    public function index ()
    {
        $roles = DB::table('roles as r')
        ->leftjoin('model_has_roles as mhr','r.id','mhr.role_id')
        ->select('r.id','r.name','r.created_at')
        ->selectraw('count(distinct mhr.model_id) as qtd_users')
        ->groupby('r.id','r.name','r.created_at')
        ->get();

        return view('roles\roles',compact('roles'));
    }

    public function create (Request $request)
    {
        $permissions = DB::table('permissions')->orderby('name')->get();

        if($request->method() == 'GET')
        {
            return view('roles\roles_create',compact('permissions'));
        }

        if(!isset($request->permissions) or count($request->permissions) == 0)
        {
            $request->flash();
            Flash("Selecione as Permissões!")->error();
            return back();
        }

        $conn = DB::connection();
        $conn->beginTransaction();

        try {
            $roles = DB::table('roles')->insertGetId([
                'name' => $request->role,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach($request->permissions as $r)
            {
                DB::table('role_has_permissions')->insert(
                [
                    'role_id' => $roles,
                    'permission_id' => $r
                ]
                );
            }

            $conn->commit();
            Flash("Perfil <b>".$request->role.'</b> criado com sucesso!')->success();
         
        } catch (\Exception $e) {
            $conn->rollback();
            if(strstr($e->getMessage(),'roles_name_guard_name_unique'))
            {
                Flash("Já existe um perfil com esse nome!")->error();
                $request->flash();
                return back();
            }
            Flash("Erro ao Gravar,Informe ao administrador!<br> ".$e->getMessage())->error();
            $request->flash();
            return back();
        }

        return redirect()->route('roles');

    }

    public function edit (Request $request)
    {


        if($request->method() == 'GET')
        {
            $role_permission = DB::table('roles as r')
            ->leftjoin('role_has_permissions as rhp','r.id','rhp.role_id')
            ->where('id',$request->id)
            ->get();

            $permissions = DB::table('permissions')->orderby('name')->get();

            return view('roles\roles_edit',compact('role_permission','permissions'));
        }

        // if(!isset($request->permissions)){
        //     Flash("Informe pelo menos uma permissão!")->warning();
        //     $request->flash();
        //     return back();
        // }


        if(!empty($request->permissions))
        {
            foreach($request->permissions as $p)
            {
                $arr_p[] = array (
                    'role_id' => $request->id,
                    'permission_id' => $p
                );
            }
        }
     

        try {
            DB::table('role_has_permissions')->where('role_id',$request->id)->delete();

            if(!empty($request->permissions))
            {
                DB::table('role_has_permissions')->insert($arr_p);
            }

      
            DB::table('roles')->where('id',$request->id)->update([
                'name' => $request->role
            ]);
            Artisan::call('cache:clear');
            // Artisan::call('config:cache');
        } catch (\Exception $e) {
            $request->flash();

            Flash("Ocorreu um erro, informe ao administrador! <br> ".$e->getMessage())->error();
            return back();
        }

        Flash("Perfil ".$request->role.' - Permissões alteradas com sucesso!')->success();
        return redirect()->route('roles');
        
    }
}
