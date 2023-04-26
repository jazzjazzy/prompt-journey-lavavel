<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use App\Models\Groups;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    function view()
    {
        $user = auth()->user();

        $subscription = $user->isSubscribed();

        if ($subscription === false) {
            return view('dashboard');
        }else{
            $plan = $user->getSubscriptionPlan();
            $projects = $user->projects()->get();

            switch ($plan->slug) {
                case 'tester':
                    return view('dashboard', []);
                    break;
                case 'monthly-user':
                case 'Yearly-user':
                case 'monthly-pro':
                case 'Yearly-pro':
                    return redirect()->route('projects.index');
                    break;
                default:
                    return view('dashboard');
                    break;
            }
        }

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
            ->where('groups.type', 'Image')
            ->where('images.user_id', $user->id);

        if ($groupId !== null && $groupId !== 'all') {
            $imagesQuery->where('image_group.group_id', $groupId);
        }


        $images = $imagesQuery->get();

        $images->map(function ($image) {
            $image->imageUrl = parse_url($image->link);
            $image->imagePath = pathinfo($image->imageUrl['path']);
            return $image;
        });

        return response()->json(['success' => true, 'images' => $images]);
    }
}
