<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Images;
use App\Models\Groups;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ImagesController extends Controller
{
    public function edit(Project $project, Images $images, Request $request): View
    {
        $user = auth()->user();
        $plan = $user->getSubscriptionPlan();

        $endGracePeriod = null;
        $projectId = $project->id;
        $imagesId = $images->id;
        $imagesName = $images->name;

        $imageUrl = parse_url($images->link);
        $imagePath =pathinfo($imageUrl['path']);

        $groupsSelected = $this->getOptionsOfGroupsByimageId($imagesId);

        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.images', [
            'imagesName' => $imagesName,
            'groupsSelected' => $groupsSelected,
            'image' => $images->link,
            'imageUrl' => $imageUrl,
            'imagePath' => $imagePath,
            'projectId'=> $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    public function view(Project $project, Request $request): view
    {
        $user = auth()->user();
        $plan = $user->getSubscriptionPlan();
        $projectId = $project->id;

        $image = $request->input('image')?? null;

        $imageUrl = parse_url($image);
        $imagePath =pathinfo($imageUrl['path']);

        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.images', [
            'imagesName' => '',
            'image' => $image,
            'imageUrl' => $imageUrl,
            'imagePath' => $imagePath,
            'projectId' => $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    public function save(Project $project, Request $request)
    {
        $user = auth()->user();
       // $plan = $user->getSubscriptionPlan();

        //if get image id by name id not null and group id not null that check if image and group already exist in images and groups table and add if it don't exist
        //else return json response with success true
        if ($this->getImagesIdByName($request->input('title')) !== null && $this->getGroupIdByName($request->input('group')) !== null) {
            $images = $this->getImagesIdByName($request->input('title'));
            $groups = $this->getGroupIdByName($request->input('group'));
            DB::table('image_group')->insertOrIgnore(['image_id' => $images, 'group_id' => $groups]);
            return response()->json(['success' => true]);
        }

        $images = new Images();
        $images->name = $request->input('title')?? null;
        $images->link = $request->input('link')?? null;
        $images->user_id = $user->id;
        $images->save();

        $groupList = Groups::where('user_id', $user->id)->get();

        $groups = explode('|', $request->input('group'));
        foreach($groups AS $groupStr) {
            //check if the $groupStr is already in $groupList and if it is, skip it
            if($groupList->contains('name', $groupStr) === false) {
                $group = new Groups();
                $group->name = $groupStr;
                $group->user_id = $user->id;
                $group->save();
            }else{
                $group = $groupList->where('name', $groupStr)->first();
            }


            $images->groups()->attach($group->id);
        }

        return response()->json(['success' => true]);
    }

    private function getImagesIdByName($imageName) : ?Images
    {
        $images = Images::where('name', $imageName)->get()->first();
        return $images;
    }

    private function getGroupIdByName($groupName) : ?Groups
    {
        $group = Groups::where('name', $groupName)->get()->first();
        return $group;
    }

    private function getOptionsOfGroupsByUserId($userId) : ?string
    {
        $group = Groups::where('user_id', $userId)->get();

        $options = [];
        //convert $group to json
        foreach($group AS  $value) {
            $option['value'] = $value->name;
            $option['text'] = $value->name;
            $options[] = $option;
        }

        return  count($options) == 0 ? null : json_encode($options);
    }

    private function getOptionsOfGroupsByimageId($imagesId) : ?string
    {
        $groups = DB::table('image_group')
            ->join('groups', 'image_group.group_id', '=', 'groups.id')
            ->where('image_group.image_id', $imagesId)
            ->get();

        $option = [];
        //convert $group to json
        foreach($groups AS  $value) {
            $option[] = $value->name;
        }

        return  count($option) == 0 ? null : json_encode($option);
    }
}
