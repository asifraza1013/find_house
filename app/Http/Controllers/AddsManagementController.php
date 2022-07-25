<?php

namespace App\Http\Controllers;

use App\AdsList;
use App\Country;
use App\Http\Controllers\Controller;
use App\ManageText;
use App\Navigation;
use App\PropertyType;
use App\Setting;
use App\User;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AddsManagementController extends Controller
{
    public function create()
    {
        $menus=Navigation::all();
        $websiteLang=ManageText::all();
        $settings=Setting::first();
        $country = Country::all();
        $propertyTypes=PropertyType::where('status',1)->get();
        return view('user.ads.create', compact([
            'country',
            'menus',
            'settings',
            'propertyTypes',
            'websiteLang',
        ]));
    }

    public function store(Request $request)
    {
        $rules = [
            'property_type'=>'required|string',
            'transactions'=>'required|string',
            'location'=>'required|string',
            // 'lat'=>'required|string',
            // 'lng'=>'required|string',
            'street_name'=>'required|string',
            'street_no'=>'required|string',
            'residential_area'=>'nullable|string',
            'email'=>'required|email',
            'phone'=>'required',
            'name'=>'required|string',
            'prefer_connection'=>'nullable|string',
            'condition'=>'required|string',
            'built_area'=>'required|string',
            'useable_area'=>'nullable|string',
            'plot_area'=>'nullable|string',
            'bedroom'=>'required|string',
            'toilets'=>'required|string',
            'orientation'=>'nullable|string',
            'floors'=>'nullable|string',
            'other_features'=>'required|array',
            'building_features'=>'required|array',
            'price'=>'required|string',
            'community_cost'=>'nullable|string',
            'description_eng'=>'required|string',
            'description_spa'=>'required|string',
            'files' => 'required|array'
        ];
        $this->validate($request, $rules);

        $ads = new AdsList();
        // dd($request->all());
        $images = [];
        $allImages = $request->files;
        foreach($allImages as $thumbnail_image1){
            foreach($thumbnail_image1 as $thumbnail_image){
                $thumbnail_extention=$thumbnail_image->getClientOriginalExtension();
                $thumb_name= 'ads-thumb-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$thumbnail_extention;
                // $thumb_path='uploads/custom-images/'.$thumb_name;
                $thumb_path='uploads/custom-images/ads';
                $thumbnail_image->move(public_path($thumb_path), $thumb_name);
                // File::put(public_path($thumb_path), $thumbnail_image);
                // Image::make($thumbnail_image)
                //     ->save(public_path()."/".$thumb_path);
                array_push($images, $thumb_path.'/'.$thumb_name);
            }
        }

        $user = User::where('email', $request->email)->first();
        if(is_null($user)){
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email_verified = 0;
            $user->password = Hash::make('123456');
            $user->status = 0;
            $user->slug = strtolower(str_replace('-', ' ', $request->name));
            $user->save();
        }

        $ads->property_type = $request->property_type;
        $ads->user_id = $user->id;
        $ads->transactions = $request->transactions;
        $ads->location = $request->location;
        $ads->street_name = $request->street_name;
        $ads->street_no = $request->street_no;
        $ads->prefer_connection = $request->prefer_connection;
        $ads->country = $request->country;
        $ads->condition = $request->condition;
        $ads->built_area = $request->built_area;
        $ads->useable_area = $request->useable_area;
        $ads->plot_area = $request->plot_area;
        $ads->total_bathroom = $request->toilets;
        $ads->total_bedroom = $request->bedroom;
        $ads->total_floor = $request->floors;
        $ads->orientation = $request->orientation;
        $ads->other_features = $request->other_features;
        $ads->building_features = $request->building_features;
        $ads->price = $request->price;
        $ads->community_cost = $request->community_cost;
        $ads->description_en = $request->description_eng;
        $ads->description_sp = $request->description_spa;
        $ads->images = $images;
        $ads->hide_street = (empty($request->hide_street)) ? false: true;
        if(!empty($request->residential_area)){
            $ads->resdential_area = $request->residential_area;
        }
        $ads->save();
        $notification=array('messege'=>'Ad created successfully. Please wait for admin side to approve.','alert-type'=>'success');
        return back()->with($notification);
    }
}
