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
            'laundry_type' => 'required'
        ]);

        try {
            LaundryPrice::create([
                'name' =>$request->name,
                'unit_type' => $request->unit_type,
                'laundry_type_id' => $request->laundry_type,
                'price' => $request->price,
                'user_id' =>auth()->user()->id
            ]);
            return response()->json(['status' => 'success']);
        }catch(\Exception $e)
        {
            return response()->json(['status' => 'failed'], 200, $headers);
        }
    }

}