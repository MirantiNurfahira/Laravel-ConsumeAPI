<?php
  
  namespace App\Http\Controllers;

use App\Http\Libraries\BaseApi;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
				//disini hanya perlu menggunakan BaseApi yg sebelumnya dibuat
				//hanya tinggal menambahkan endpoint yg akan digunakan yaitu '/user'
        $users = (new BaseApi)->index('/user');

        return view('users.index')->with(['users' => $users]);
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
			// buat variable baru untuk menset parameter agar sesuai dengan documentasi
		$payload = [
            'firstName' => $request->input('nama_depan'),
            'lastName' => $request->input('nama_belakang'),
            'email' => $request->input('email'),
        ];

        $baseApi = new BaseApi;
        $response = $baseApi->create('/user/create', $payload);

		// handle jika request API nya gagal
        // diblade nanti bisa ditambahkan toast alert
        if ($response->failed()) {
			// $response->json agar response dari API bisa di akses sebagai array
            $errors = $response->json('data');

            $messages = "<ul>";

            foreach ($errors as $key => $msg) {
                $messages .= "<li>$key : $msg</li>";
            }

            $messages .= "</ul>";

            $request->session()->flash(
                'message',
                "Data gagal disimpan
                $messages",
            );

            return redirect()->back();
        }

        $request->session()->flash(
            'message',
            'Data berhasil disimpan',
        );

        return redirect('/users');
    }
    public function show($id)
    {
            $response = (new BaseApi)->detail('/user', $id);
                return view('users.edit')->with([
                'user' => $response->json()
                ]);
    }

    public function edit(User $user)
    {
        return view('users.edit');
    }

    public function update(Request $request, $id)
{
    $payload = [
        'firstName' => $request->input('nama_depan'),
        'lastName' => $request->input('nama_belakang'),
    ];

    $response = (new BaseApi)->update('/user', $id, $payload);
    if ($response->failed()) {
        $errors = $response->json();
        return redirect('users');
    }

    $request->session()->flash(
        'message',
        'Data berhasil disimpan',
    );

    return redirect('users');
}
    public function destroy(Request $request, $id)
    {
        $response = (new BaseApi)->delete('/user', $id);

        if ($response->failed()) {
            $request->session()->flash(
                'message',
                'Data gagal dihapus'
            );

            return redirect('users');
        }

        $request->session()->flash(
            'message',
            'Data berhasil dihapus',
        );

        return redirect('users');
    }
}