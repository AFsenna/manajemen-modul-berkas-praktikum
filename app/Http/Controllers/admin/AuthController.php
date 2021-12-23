<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
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
        return view('auth.loginAdmin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://labinformatika.itats.ac.id/api/login-admin', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode(
                [
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            )
        ]);

        $decodeResponse = json_decode($response->getBody()->getContents());
        if ($decodeResponse->status != "failed") {
            $data =  $decodeResponse->users;
            $admin = User::where('role', 0)->where('credential', $data[2])->first();
            if (is_null($admin)) {
                $admin = User::create([
                    'role' => 0,
                    'credential' => $data[2],
                    'name' => ucfirst($data[0]),
                ]);
                Auth::login($admin);
            } else {
                Auth::login($admin);
            }
            return redirect('/dashboard-admin');
        } else {
            return redirect('/login-admin')->with(['jenis' => 'error', 'pesan' => 'Gagal Login!']);
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

        return redirect('/login-admin');
    }
}
