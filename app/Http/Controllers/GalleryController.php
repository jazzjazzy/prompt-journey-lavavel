<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
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
        $groups = Groups::where('user_id', $user->id)
            ->where('groups.type', 'Image')
            ->get();

        $images->map(function ($image) {
            $image->imageUrl = parse_url($image->link);
            $image->imagePath = pathinfo($image->imageUrl['path']);

            return $image;
        });

        return view('modals.gallery', [
            'images' => $images,
            'groups' => $groups,
        ]);
    }

    function viewImages($groupId = null)
    {
        $user = auth()->user();

        $imagesQuery = DB::table('images');

        if($groupId === 'no-group') {
            $imagesQuery->select('images.*')
                ->leftJoin('image_group', 'images.id', '=', 'image_group.image_id')
                ->leftJoin('groups', 'groups.id', '=', 'image_group.group_id')
                ->where('groups.id', null)
                ->where('images.user_id', $user->id);
        } else {
            if ($groupId === 'all') {
                $imagesQuery->where('images.user_id', $user->id);
            }else {
                $imagesQuery->select('images.*')
                    ->Join('image_group', 'images.id', '=', 'image_group.image_id')
                    ->Join('groups', 'groups.id', '=', 'image_group.group_id')
                    ->where('groups.type', 'Image')
                    ->where('images.user_id', $user->id)
                    ->where('image_group.group_id', $groupId);
            }
        }

        $images = $imagesQuery->get(); // Execute the query and get the results

        $images->map(function ($image) {
            $image->imageUrl = parse_url($image->link);
            $image->imagePath = pathinfo($image->imageUrl['path']);
            return $image;
        });

        return response()->json(['success' => true, 'images' => $images]);
    }
}
