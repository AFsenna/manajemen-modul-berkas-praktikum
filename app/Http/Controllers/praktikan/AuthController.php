<?php

namespace App\Http\Controllers\praktikan;

use App\Http\Controllers\Controller;
use App\Models\User;
use app\Helpers\ApiLabinfor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            if (auth()->user()->role == 0) {
                return redirect()->route('admin.dashboard')->with(['jenis' => 'warning', 'pesan' => 'Silahkan logout dahulu jika ingin ke halaman login Admin!']);
            } else if (auth()->user()->role == 1) {
                return redirect()->route('praktikan.dashboard')->with(['jenis' => 'warning', 'pesan' => 'Silahkan logout dahulu jika ingin ke halaman login Praktikan!']);
            }
        }
        return view('auth.loginPraktikan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $login = ApiLabinfor::loginPraktikan($request->npm, $request->password);
        if ($login->status != "failed") {
            $data =  $login->users;
            $praktikan = User::where('role', 1)->where('credential', $data[0])->first();
            if (is_null($praktikan)) {
                $praktikan = User::create([
                    'role' => 1,
                    'credential' => $data[0],
                    'name' => ucfirst($data[1]),
                    'email' => $data[4],
                ]);
                Auth::login($praktikan);
            } else {
                $id = $praktikan->id;
                $user =  User::find($id);

                $user->update([
                    'email' => $data[4],
                ]);
                Auth::login($praktikan);
            }
            return redirect()->route('praktikan.dashboard');
        } else {
            return redirect('login-praktikan')->with(['jenis' => 'error', 'pesan' => 'Gagal Login!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login-praktikan');
    }
}
