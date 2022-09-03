<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Gallery;
use App\TravelPackage;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{

    public function index()
    {
        $item = Gallery::with(['travel_packages'])->get();
        // dd($item);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Gallery',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'gallery',
            'items' => $item
        ];
        // dd($data);
        return view('pages.admin.gallery.index', $data);
    }
    public function create()
    {
        $travel_packages = TravelPackage::all();

        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Tambah Gallery',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'gallery',
            'travel_package' => $travel_packages
        ];
        // dd($data);
        return view('pages.admin.gallery.create', $data);
    }

    public function store(GalleryRequest $request)
    {
        $data = $request->all();
        $image = null;
        if ($files = $request->file('image')) {
            $carImage = time() . '.' . $files->getClientOriginalExtension();
            $request->image->move(public_path('assets/gallery'), $carImage);

            $image = $carImage;
            $data['image'] = $image;
            Gallery::create($data);
            return redirect()->route('gallery.index')->with('sukses', 'Data Berhasil Ditambah');
        }
    }

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
        $item = Gallery::findOrFail($id);
        $travel_packages = TravelPackage::all();
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Tambah Gallery',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'gallery',
            'item' => $item,
            'travel_package' => $travel_packages
        ];

        return view('pages.admin.gallery.edit', $data);
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
        $data = $request->all();
        $item = Gallery::findOrFail($id);
        // dd($item->image);
        if ($files = $request->file('image')) {
            unlink(public_path('assets/gallery/' . $item->image));
            $carImage = time() . '.' . $files->getClientOriginalExtension();
            $request->image->move(public_path('assets/gallery'), $carImage);

            $image = $carImage;
            $data['image'] = $image;
            $item->update($data);

            return redirect()->route('gallery.index')->with('sukses', 'Data Berhasil Diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = Gallery::findOrFail($id);
        if ($item->image) {
            unlink(public_path('assets/gallery/' . $item->image));
            $item->delete();
            return redirect()->route('gallery.index')->with('sukses', 'Data Berhasil Dihapus');
        }
    }
}
