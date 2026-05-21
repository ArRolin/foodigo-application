<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Offer;
use App\Models\OfferProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Product\App\Models\Product;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $offer = Offer::first();
        return view('admin.offer.index', compact('offer'));
    }

    public function update(Request $request){

        $rules = [
            'title'=>'required',
            'description'=>'required',
            'end_time'=>'required|date',
            'offer'=>'required|numeric',
        ];

        $customMessages = [
            'title.required' => trans('translate.Title is required'),
            'description.required' => trans('translate.Description is required'),
            'offer.required' => trans('translate.Offer is required'),
            'end_time.required' => trans('translate.End time is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $offer = Offer::first();

        if (!$offer) {
            $offer = new Offer();
        }

        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->offer = $request->offer;
        $offer->end_time = $request->end_time;
        $offer->status = $request->status == 'on' ? 1 : 0;
        $offer->save();

        $notification=trans('translate.Update Successfully');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function offer_product(){
        $products = Product::where('status', 'enable')->get();
        $offer_products = OfferProduct::with('product')->get();

        return view('admin.offer.offer_product', compact('offer_products','products'));
    }

    public function store(Request $request){

        $isProductExist = OfferProduct::where(['product_id' => $request->product_id])->count();

        $rules = [
            'product_id'=> $isProductExist == 0 ? 'required' : 'required|unique:offer_products',
        ];

        $customMessages = [
            'product_id.required' => trans('translate.Product is required'),
            'product_id.unique' => trans('translate.Product already exist'),
            'status.required' => trans('translate.Status is required'),
        ];

        $this->validate($request, $rules,$customMessages);

        $offer_product = new OfferProduct();
        $offer_product->product_id = $request->product_id;
        $offer_product->status = 1;
        $offer_product->save();

        $notification=trans('translate.Added Successfully');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }


    public function destroy($id)
    {
        $offer_product = OfferProduct::findOrFail($id);
        $offer_product->delete();

        $notification=trans('translate.Deleted Successfully');
        $notification=array('message'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
