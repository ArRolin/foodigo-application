<?php

namespace App\Http\Controllers\Admin;

use Image, File, Str;
use App\Models\Banner;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Modules\Page\App\Models\Homepage;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $banners = Banner::all();
        return view('admin.banner.index', ['banners' => $banners]);
    }

    public function create(){
        return view('admin.banner.create');
    }

    public function store(Request $request){

        $request->validate([
            'image' => 'required',
            'url' => 'required',
        ]);


        $banner = new Banner();

        if ($request->image) {
            $extention = $request->image->getClientOriginalExtension();
            $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name = 'uploads/custom-images/' . $image_name;
            Image::make($request->image)
                ->save(public_path() . '/' . $image_name);
            $banner->image = $image_name;
        }

        $banner->url = $request->url;
        $banner->status = $request->status == 'on' ? 1 : 0;
        $banner->save();

        $message = trans('translate.Created successfully');
        $notification = array('message' => $message, 'alert-type' => 'success');
        return redirect()->route('admin.banner')->with($notification);
    }

    public function edit($id){

        $banner = Banner::findOrFail($id);

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'url' => 'required',
        ]);

        $banner = Banner::findOrFail($id);

        if($request->image){
            $old_image = $banner->image;
            $extention = $request->image->getClientOriginalExtension();
            $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->image)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $banner->image = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $banner->url = $request->url;
        $banner->status = $request->status == 'on' ? 1 : 0;
        $banner->save();

        $message = trans('translate.Updated successfully');
        $notification = array('message' => $message, 'alert-type' => 'success');
        return redirect()->route('admin.banner')->with($notification);
    }

    public function delete($id){

        $banner = Banner::findOrFail($id);

        $old_image = $banner->image;

        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }

        $banner->delete();

        $notify_message = trans('translate.Deleted successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->route('admin.banner')->with($notify_message);
    }

    public function promotional_banner_edit(){
        $homepage = Homepage::first();
        return view('admin.banner.promotional_banner', compact('homepage'));
    }

    public function promotional_banner_update(Request $request) {

        $request->validate([
            'promotional_banner_one_url' => 'required',
            'promotional_banner_two_url' => 'required',
            'promotional_banner_restaurant_url' => 'required',
            'blog_banner_two_link' => 'required',
        ]);

        $homepage = Homepage::first();

        if($request->promotional_banner_one){
            $old_image = $homepage->promotional_banner_one;
            $extention = $request->promotional_banner_one->getClientOriginalExtension();
            $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->promotional_banner_one)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $homepage->promotional_banner_one = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->promotional_banner_two){
            $old_image = $homepage->promotional_banner_two;
            $extention = $request->promotional_banner_two->getClientOriginalExtension();
            $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->promotional_banner_two)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $homepage->promotional_banner_two = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->promotional_banner_restaurant){
            $old_image = $homepage->promotional_banner_restaurant;
            $extention = $request->promotional_banner_restaurant->getClientOriginalExtension();
            $image_name = Str::slug($request->name) . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->promotional_banner_restaurant)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $homepage->promotional_banner_restaurant = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->blog_banner_one){
            $old_image = $homepage->blog_banner_one;
            $extention = $request->blog_banner_one->getClientOriginalExtension();
            $image_name = Str::slug('blog_banner_one') . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->blog_banner_one)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $homepage->blog_banner_one = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->blog_banner_two){
            $old_image = $homepage->blog_banner_two;
            $extention = $request->blog_banner_two->getClientOriginalExtension();
            $image_name = Str::slug('blog_banner_two') . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
            $image_name ='uploads/custom-images/'.$image_name;
            Image::make($request->blog_banner_two)
                ->encode('webp', 80)
                ->save(public_path().'/'.$image_name);
            $homepage->blog_banner_two = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $homepage->promotional_banner_one_url = $request->promotional_banner_one_url;
        $homepage->promotional_banner_two_url = $request->promotional_banner_two_url;
        $homepage->promotional_banner_restaurant_url = $request->promotional_banner_restaurant_url;
        $homepage->blog_banner_two_link = $request->blog_banner_two_link;
        $homepage->blog_banner_one_link = $request->blog_banner_one_link;

        $homepage->promotional_banner_one_status = $request->promotional_banner_one_status == 'on' ? 1 : 0;
        $homepage->promotional_banner_two_status = $request->promotional_banner_two_status == 'on' ? 1 : 0;
        $homepage->promotional_banner_restaurant_status = $request->promotional_banner_restaurant_status == 'on' ? 1 : 0;
        $homepage->blog_banner_one_status = $request->blog_banner_one_status == 'on' ? 1 : 0;
        $homepage->blog_banner_two_status = $request->blog_banner_two_status == 'on' ? 1 : 0;
        $homepage->save();


        $notify_message = trans('translate.Updated successfully');
        return redirect()->back()->with(['message' => $notify_message, 'alert-type' => 'success']);
    }

}
