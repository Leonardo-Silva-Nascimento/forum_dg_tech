<?php

namespace App\Http\Controllers;

use App\Mail\SendTemporaryPassword;
use App\Models\User;
use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Spatie\Permission\Models\Permission;
use stdClass;
use \Spatie\Permission\Models\Role;

class Userlist extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();

        return Inertia::render('User/Create', [
            'roles' => $roles,
        ]);
    }

    public function editProfile()
    {
        $user_id = auth()->user()->id;

        $roles = Role::all();
        $user = User::findOrFail($user_id);

        $user['link_group'] = "true";

        if ($user->permissions->count()) {
            $user['link_group'] = "false";
        }

        $user->load(['permissions', 'roles']);
        $UsuarioAtual = DB::table("users")->where('id', $user_id)->first();
        $EmpresaExplodeUsuarioAtual = explode(',', $UsuarioAtual->empresa);


        $data = Session::all();

        $arr = '';

        return Inertia::render('User/Profile', [
            'roles' => $roles,
            'user' => $user,
            'SelectEmpresa' => $arr,
        ]);
    }

    public function updateProfile(Request $request)
    {

        $user_id = auth()->user()->id;

        if ($request->empresaSelect) {
            $EmpresaImplode = implode(',', $request->empresaSelect);
        }

        $UsuarioAtual = DB::table("users")->where('id', $user_id)->first();

        $url = null;
        $rules = 'jpg,png';
        $FormatosLiberados = explode(",", $rules);
        if ($request->hasFile('profile_picture')) {
            if ($request->file('profile_picture')->isValid()) {
                if (in_array($request->file('profile_picture')->extension(), $FormatosLiberados)) {
                    $ext = $request->file('profile_picture')->extension();
                    $profile_picture = $request->file('profile_picture')->store('avatars/1');
                    $url = $profile_picture;
                    $url = explode('/', $url);
                    $url = $profile_picture;
                } else {
                    $ext = $request->file('profile_picture')->extension();
                    return redirect()->route("form.update.profile")->withErrors(['msg' => "Atenção o formato enviado na Foto de Perfil foi: $ext, só são permitidos os seguintes formatos: $rules ."]);
                }
            }
        }

        $save = new stdClass;
        $save->name = $request->name;
        $save->email = $request->email;
        if ($request->password) {
            $save->password = bcrypt($request->password);
        }
        if ($request->profile_picture) {
            $save->profile_picture = $url;
        }

        $save = collect($save)->toArray();
        DB::table("users")
            ->where("id", $user_id)
            ->update($save);

        if ($request->empresaSelect) {
            session(['empresa' => $EmpresaImplode]);
        }

        return redirect()->route('home');
    }

    public function create()
    {

        $roles = Role::all();

        return Inertia::render('User/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {

        $Usuarios = DB::table("users")->where("email", $request->email)->first();
        if ($Usuarios) {
            return redirect()->route("form.store.user")->withErrors(['msg' => "E-mail já cadastrado em nossa base de dados."]);
        }

        $Array = array();

        $save = new stdClass;
        $save->name = $request->name;
        $save->email = $request->email;
        $save->password = bcrypt($request->password);
        $save->status = 1;

        $save = collect($save)->toArray();
        DB::table("users")
            ->insert($save);
        $lastId = DB::getPdo()->lastInsertId();

        $user = User::find($lastId);

        return redirect()->route('login');
    }


}
