<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MahasiswaController extends Controller
{
    public function index()
    {
        return "Berhasil di proses";
    }

    public function insertSql()
    {
        $result = DB::insert("INSERT INTO mahasiswas(nim,nama,tanggal_lahir,ipk) VALUES ('19161244','Adri Lukman','1998-08-19',3.5)"); //RAW query ,biasanya digunakan ketika querynya Sangat komplek dan tidak bisa menggunakan query buikder atau eloquent

        dump($result);
    }

    public function insertTimestamp()
    {
        $result = DB::insert("INSERT INTO mahasiswas(nim,nama,tanggal_lahir,ipk,created_at,updated_at) VALUES ('19161255','Sity Susansah','1998-08-15',3.3,now(),now())");
        dump($result);
    }

    public function insertPrepared()
    {
        $result = DB::insert(
            "INSERT INTO mahasiswas (nim,nama,tanggal_lahir,ipk,created_at,updated_at)
        VALUES(?,?,?,?,?,?)",
            ['19161266', 'Indra Supriadi', '1997-11-13', 3.7, now(), now()]
        );   //Supaya lebih aman dari SQL injection

        dump($result);
    }

    public function insertBinding()
    {
        $result = DB::insert(
            "INSERT INTO mahasiswas(nim,nama,tanggal_lahir,ipk,created_at,updated_at)
        VALUES (:nim,:nama,:tgl,:ipk,:created,:updated)",
            [
                'nim' => "19161277",
                'nama' => "Arti Haryanti",
                'tgl' => "1997-06-15",
                'ipk' => 3.4,
                'created' => now(),
                'updated' => now(),
            ]
        );                                  //memakai teknik named parameter
        dump($result);
    }

    public function update()
    {
        $result = DB::update("UPDATE mahasiswas SET created_at =now(), updated_at = now() WHERE nim=?", ['19161244']);
        dump($result);
    }

    public function delete()
    {
        $result = DB::delete("DELETE FROM mahasiswas WHERE nama=?", ['Arti Haryanti']);
        dump($result);
    }

    public function select()
    {
        $result = DB::select("SELECT * FROM mahasiswas");
        dump($result);
    }

    public function selectTampil()
    {
        $result = DB::select('SELECT * FROM mahasiswas');
        echo ($result[0]->id) . '<br>';
        echo ($result[0]->nim) . '<br>';
        echo ($result[0]->nama) . '<br>';
        echo ($result[0]->tanggal_lahir) . '<br>';
        echo ($result[0]->ipk);

        // foreach ($result as $value) {
        //     echo $value->nim . "<br>";
        //     echo $value->nama . "<br>";
        // }
    }

    public function selectView()
    {
        $result = DB::select("SELECT * FROM mahasiswas");
        return view('tampil-mahasiswa', ['mahasiswas' => $result]);
        // return view('tampil-mahasiswa');
    }

    public function selectWhere()
    {
        $result = DB::select("SELECT * FROM mahasiswas WHERE ipk >? ORDER BY  nama ASC ", [3]);
        return view('tampil-mahasiswa', ['mahasiswas' => $result]);  //Passing cara 1
        // return view('tampil-mahasiswa', compact('result')); //Passing cara 2
        // return view('tampil-mahasiswa')->with('mahasiswas', $result); //Passing cara 3
    }

    public function statement()
    {
        $result = DB::statement("TRUNCATE mahasiswas");
        return ('Tabel mahasiswa sudah dikosongkan');
    }

    public function show()
    {
        $mahasiswas = DB::table('mahasiswas')->get();

        // dump($mahasiswas);

        return view('tampil-mahasiswa', ['mahasiswas' => $mahasiswas]);
    }
}
