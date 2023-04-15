<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use App\Models\Groups;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    function view()
    {
        $user = auth()->user();
        $images = Images::all()->where('user_id', $user->id);
        $groups = Groups::all()->where('user_id', $user->id);

        $images->map(function ($image) {
            $image->imageUrl = parse_url( $image->link);
            $image->imagePath = pathinfo($image->imageUrl['path'] );

            return $image;
        });

        return view('modals.gallery', [
            'images' => $images,
            'groups' => $groups,
        ]);
    }

    function viewImages($groupId)
    {
        $user = auth()->user();

        $images = DB::table('images')
            ->join('image_group', 'images.id', '=', 'image_group.image_id')
            ->where('image_group.group_id', $groupId)
            ->where('images.user_id', $user->id)
            ->get();


        $images->map(function ($image) {
            $image->imageUrl = parse_url( $image->link);
            $image->imagePath = pathinfo($image->imageUrl['path']);

            return $image;
        });

        return response()->json(['success' => true, 'images' => $images]);
    }
}