<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LaundryType;
use App\LaundryPrice;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    public function index()
    {
        $products = LaundryPrice::with(['type', 'user'])->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $products = $products->where('name', 'LIKE', '%' . request()->q . '%');
        }
        $products = $products->paginate(10);
        return new ProductCollection($products);
    }

    public function getLaundryType()
    {
        $type =LaundryType::orderBy('name', 'ASC')->get();
        return response()->json(['status' => 'success', 'data' => $type]);
    }

    public function storeLaundryType(Request $request)
    {
        /* validasi nilai yang akan dikirim apabila gagal akan muncul error 422
         * apabila mendapati error 422 cek kembali rule validasi di bawah ini
         */
        $this->validate($request, [
            'name_laundry_type' => 'required|unique:laundry_types,name'
        ]);

        LaundryType::create(['name' => $request->name_laundry_type]);
        return response()->json(['status' => 'success']);
    }

    public function store(Request $request)
    {
         /* validasi nilai yang akan dikirim apabila gagal akan muncul error 422
         * apabila mendapati error 422 cek kembali rule validasi di bawah ini
         */
        $this->validate($request, [
            'name' =>'required|string|max:100',
            'unit_type' => 'required',
            'price' => 'required|integer',
            'laundry_type' => 'required',
            'service' => 'required|integer',
            'service_type' => 'required'
        ]);

        try {
            LaundryPrice::create([
                'name' =>$request->name,
                'unit_type' => $request->unit_type,
                'laundry_type_id' => $request->laundry_type,
                'price' => $request->price,
                'user_id' =>auth()->user()->id,
                'service' => $request->service,
                'service_type' => $request->service_type
            ]);
            return response()->json(['status' => 'success']);
        }catch(\Exception $e)
        {
            return response()->json(['status' => 'failed']);
        }
    }
    // Fungsi edit data product dengan cara mengambil $id data yang akan di edit
    public function edit($id)
    {
        $laundry = LaundryPrice::find($id);
        return response()->json(['status' => 'success', 'data' => $laundry]);
    }
    //  Fungsi update data setelah selesai melakukan edit data
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>'required|string|max:100',
            'unit_type' => 'required',
            'price' => 'required|integer',
            'laundry_type' => 'required',
            'service' => 'required|integer',
            'service_type' => 'required'
        ]);

        $laundry = LaundryPrice::find($id);
        $laundry->update([
            'name' => $request->name,
            'unit_type' => $request->unit_type,
            'laundry_type_id' => $request->laundry_type,
            'price' => $request->price,
            'service' => $request->service,
            'service_type' => $request->service_type

        ]);

        return response()->json(['status' => 'success']);
    }
    // Fungsi untuk menghapus data pada Products Section
    public function destroy($id)
    {
        $laundry = LaundryPrice::find($id);
        $laundry->delete();
        return response()->json(['status' => 'success']);
    }

}