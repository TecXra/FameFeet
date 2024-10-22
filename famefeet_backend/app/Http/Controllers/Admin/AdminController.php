<?php

namespace App\Http\Controllers\Admin;

use FFMpeg\FFMpeg;
use App\Http\Controllers\Controller;
use App\Models\User;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\WMV;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use const Grpc\STATUS_OUT_OF_RANGE;

class AdminController extends Controller
{
    //
    public function addAdmin(Request $request){
        $request->validate([
            'username' => 'required|string|between:4,100|unique:users',
            'email' => 'required|string|email|max:100|unique:users|regex:/^[^\.]+(\.[^\.]+)*@[^\.]+\.[^\.]+$/',
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
            'phone_number' => 'required|string|min:11',
            'date_of_birth' => 'required',
        ]);
        User::create([
            'username' =>  $request->username,
            'email' => $request->email,
            'phone_number'=> $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'password' => bcrypt($request->password),
            'referral_code' => Str::random(6),
            'user_type' => config('famefeet.user_type.admin'),
            'is_online' => true,
            'account_status' => config('famefeet.account_status.active'),
        ]);
        return Redirect::back()->with('success','New Admin Added Successfully');
    }

    public function videoUpload(Request $request){
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'=>'E:\ffmpeg\ffmpeg\bin\ffmpeg.exe',
            'ffprobe.binaries'=>'E:\ffmpeg\ffmpeg\bin\ffprobe.exe'
        ]);
        $video = $ffmpeg->open($request['video']);
        $ffprobe = FFProbe::create([
            'ffmpeg.binaries'=>'E:\ffmpeg\ffmpeg\bin\ffmpeg.exe',
            'ffprobe.binaries'=>'E:\ffmpeg\ffmpeg\bin\ffprobe.exe'
        ]);
        $duration = $ffprobe->streams($request['video'])->videos()->first()->get('duration');
        $video
            ->save(new X264(), Storage::path('public/upload/export-wmv.mp4'));
        return $duration;
        return true;
    }

}
