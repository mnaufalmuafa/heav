<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => User::getPublisherData(session('id')),
        ];
        return view('pages.publisher.dashboard', $data);
    }

    public function bePublisher()
    {
        $id = session('id');
        User::bePublisher($id);
        return true;
    }

    public function editDataPublisher()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => User::getPublisherData(session('id')),
        ];
        return view('pages.publisher.edit', $data);
    }

    public function updateDataPublisher(Request $request)
    {
        $this->validate($request, [
            'foto' => 'file|image|mimes:jpeg,png,jpg',
            'nama' => '',
            'deskripsi' => '',
        ]);
        $id = session('id');
        $foto = $request->foto;

        if ($foto != null) { //Jika publisher mengupdate foto
            $newId = $this->getNewProfilePhotoId();
            $file = $request->file('foto');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'image/profile_photos/'.$newId;
            $file->move($tujuan_upload,$nama_file);
            $this->updateFoto($nama_file, $id, $newId);
        }
        // echo $request->nama;
        // echo $request->deskripsi;
        return redirect()->route('dashboard-publisher');
    }

    private function updateFoto($foto, $idUser, $idFoto) {
        DB::table('profile_photos')->insert([
            "id" => $idFoto,
            "name" => $foto,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('publishers')->where('userId', $idUser)
            ->update([
                "profilePhotoId" => $idFoto,
            ]);
    }

    public static function getNewProfilePhotoId()
    {
        return DB::table('profile_photos')->get()->count() + 1;
    }
}
