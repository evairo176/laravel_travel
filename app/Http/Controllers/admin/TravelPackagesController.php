<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TravelPackagesRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\TravelPackage;
use Datatables;
use Illuminate\Support\Facades\Validator;

class TravelPackagesController extends Controller
{

    public function index(Request $request)
    {
        $travel_package = TravelPackage::where('travel_packages.deleted_at', null)->get();
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Travel Packages',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'travelpackages',
        ];

        if (request()->ajax()) {
            return datatables()->of($travel_package)
                ->addIndexColumn()
                ->addColumn('cek', 'pages.admin.travel-packages.checkbox')
                ->addColumn('action', 'pages.admin.travel-packages.travel-package-action')
                ->addColumn('image', 'pages.admin.travel-packages.image')
                ->rawColumns(['action', 'image', 'cek'])
                ->make(true);
        }
        // dd($data);
        return view('pages.admin.travel-packages.index', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'location' => 'required|max:255',
            'language' => 'required',
            'about' => 'required',
            'featured_event' => 'required|max:255',
            'foods' => 'required|max:255',
            'departure_date' => 'required|date',
            'duration' => 'required|max:255',
            'type' => 'required|max:255',
            'price' => 'required|integer',
            'image' => 'required|image',
        ]);
        if ($validator->passes()) {
            $travelId = $request->id;
            $images = $request->file('image');
            if ($travelId) {
                $travel = TravelPackage::find($travelId);
                if ($request->hasFile('image')) {
                    unlink(public_path('assets/gallery/' . $travel->image));

                    //image
                    $carImage = time() . '.' . $images->getClientOriginalExtension();
                    $request->image->move(public_path('assets/gallery'), $carImage);
                    $travel->image = $carImage;
                }
            } else {
                $travel = new TravelPackage();
                //image
                $carImage = time() . '.' . $images->getClientOriginalExtension();
                $request->image->move(public_path('assets/gallery'), $carImage);
                $travel->image = $carImage;
            }
            $travel->title = $request->title;
            $travel->slug = Str::slug($request->title);
            $travel->location = $request->location;
            $travel->about = $request->about;
            $travel->language = $request->language;
            $travel->featured_event = $request->featured_event;
            $travel->foods = $request->foods;
            $travel->departure_date = $request->departure_date;
            $travel->duration = $request->duration;
            $travel->type = $request->type;
            $travel->price = $request->price;
            $travel->save();

            return Response()->json([
                'travel' => $travel,
                'success' => true,
                'message' => 'Data inserted successfully'
            ]);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $travel  = TravelPackage::where($where)->first();

        return Response()->json($travel);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->data;
        if ($data != '') {
            if ($request->multi != null) {
                foreach ($data as $key) {
                    $delete = TravelPackage::find($key);
                    unlink(public_path('assets/gallery/' . $delete->image));
                    $delete->delete();
                }
            } else {
                $delete = TravelPackage::find($request->data);
                unlink(public_path('assets/gallery/' . $delete->image));
                $delete->delete();
            }
            return Response()->json($delete);
        } else {
            $text = 'Data select kosong';
            return Response()->json([
                'text' => $text
            ]);
        }
    }
}
