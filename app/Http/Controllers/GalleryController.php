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

        $imagesQuery = DB::table('images')
            ->join('image_group', 'images.id', '=', 'image_group.image_id')
            ->join('groups', 'groups.id', '=', 'image_group.group_id')
            ->where('groups.type', 'Image')
            ->where('images.user_id', $user->id);

        if ($groupId !== null && $groupId !== 'all') {
            $imagesQuery->where('image_group.group_id', $groupId);
        }


        $sql = $imagesQuery->toSql(); // Get the SQL query being executed
        $bindings = $imagesQuery->getBindings(); // Get the parameter bindings for the query
        $images = $imagesQuery->get(); // Execute the query and get the results

        /*dump($groupId);
        dump("SQL query: $sql");
        dump("Bindings: " . json_encode($bindings));
        dd("Results: " . json_encode($images));*/

        $images->map(function ($image) {
            $image->imageUrl = parse_url($image->link);
            $image->imagePath = pathinfo($image->imageUrl['path']);
            return $image;
        });

        return response()->json(['success' => true, 'images' => $images]);
    }
}
