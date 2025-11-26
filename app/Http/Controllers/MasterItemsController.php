<?php

namespace App\Http\Controllers;

// use Barryvdh\DomPDF\PDF;
use App\Models\MasterItem;

use App\Models\KategoriItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MasterItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        // $data_search = MasterItem::query();
        $data_search = MasterItem::with('kategoriItems');

        // bagian ini buat flexible pencarian
        if (!empty($kode)) {
            $data_search = $data_search->where('kode', $kode);
        }
        if (!empty($nama)) {
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }
        // Perbaikan filter harga
        if (!empty($hargamin) && !empty($hargamax)) {
            $data_search = $data_search->whereBetween('harga_beli', [$hargamin, $hargamax]);
        } elseif (!empty($hargamin)) {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        } elseif (!empty($hargamax)) {
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        // $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();
        $data_search = $data_search->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = null; // lebih baik null daripada array kosong
        } else {
            $item = MasterItem::find($id);
        }

        // ambil semua kategori untuk dropdown
        $kategori = KategoriItem::all();

        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategori'] = $kategori; // penambahan kategori for view in table

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategoriItems')
                            ->where('kode', $kode)
                            ->first();

        return view('master_items.single.index', $data);

    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id') + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(1);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            if ($data_item->foto && Storage::disk('public')->exists($data_item->foto)) {
                \Storage::disk('public')->delete($data_item->foto);
            }
            $path = $request->file('foto')->store('foto_barang', 'public');
            $data_item->foto = $path;
        }

        // simpan dulu supaya dapat ID
        $data_item->save();

        // simpan relasi kategori (many-to-many)
        if ($request->has('kategori_id')) {
            $data_item->kategoriItems()->sync($request->kategori_id);
        }

        return redirect('master-items');
    }
    
    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }

    public function downloadPDF($id)
    {
        $data = MasterItem::with('kategoriItems')->findOrFail($id);

        $pdf = Pdf::loadView('master_items.pdf', compact('data'));

        return $pdf->download('master_item_'.$data->id.'.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new MasterItemsExport, 'master_items.xlsx');
    }
}
