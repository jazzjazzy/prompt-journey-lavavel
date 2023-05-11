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
        $user->accessLevels = $user->getAccessLevels();

        $endGracePeriod = null;
        $projectId = $project->id;
        $imagesId = $images->id;
        $imagesName = $images->name;

        $image = $this->createUrlFromQueryStrings($request);

        $imageUrl = parse_url($images->link);
        $imagePath = pathinfo($imageUrl['path']);


        $groupsSelected = $this->getOptionsOfGroupsByimageId($imagesId);

        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.images', [
            'buttonRow' => null,
            'user' => $user,
            'imagesName' => $imagesName,
            'groupsSelected' => $groupsSelected,
            'image' => $images->link,
            'imageUrl' => $imageUrl,
            'imagePath' => $imagePath,
            'projectId' => $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    public function view(Project $project, Request $request): view
    {
        $user = auth()->user();
        $projectId = $project->id;
        $user->accessLevels = $user->getAccessLevels();

        $image = $this->createUrlFromQueryStrings($request) ?? null;
        $buttonRow = $request->input('rowId') ?? null;

        $imageUrl = parse_url($image);
        $imagePath = pathinfo($imageUrl['path']);

        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.images', [
            'buttonRow' => $buttonRow,
            'user' => $user,
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

        // see if the image already exists in the database
        $image = $this->getImagesIdByName($request->input('title'));

        // get a list of groups that the image is already in
        $groupList =  Groups::join('image_group', 'groups.id', '=', 'image_group.group_id')
            ->where('groups.user_id', $user->id)
            ->where('image_group.image_id', $image->id)
            ->select('groups.*') // Optional: Select only the 'groups' table columns
            ->get();

        // get the list group that we want this image in from the request
        $groups = explode('-::-', $request->input('group'));

        // loop through the list of groups and add them to the image_group table
        foreach ($groups as $groupStr) {

            // get the group id by name
            $group = $this->getGroupIdByName($groupStr);

            //
            if ($image instanceof $image && $group instanceof Groups) {
                DB::table('image_group')->insertOrIgnore(['image_id' => $image->id, 'group_id' => $group->id]);
                continue;
            }

            // if the image or group don't exist, create them
            $image = $image ?? new Images();
            $group = $group ?? new Groups();

            // save the image
            $image->name = $request->input('title') ?? null;
            $image->link = $request->input('link') ?? null;
            $image->user_id = $user->id;
            $image->save();

            // save the group if it doesn't exist in the database
            if ($groupList->contains('name', $groupStr) === false) {
                $group->name = $groupStr;
                $group->type = 'Image';
                $group->user_id = $user->id;
                $group->save();
            } else {
                // if the group does exist, get the group object
                $group = $groupList->where('name', $groupStr)->first();
            }
            // add the image to the group
            $image->groups()->attach($group->id);
        }

        // need to check if any groups have been removed and remove them from the image_group table if they have
        $groupsToRemove = [];
        foreach ($groupList as $group) {
            if (in_array($group->name, $groups) === false) {
                $groupsToRemove[] = $group->id;
            }
        }
        // if we find groups that need to be removed, remove them
        if($groupsToRemove !== []) {
            DB::table('image_group')->whereIn('group_id', $groupsToRemove)->delete();
        }

        return response()->json(['success' => true, 'imageId' => $image->id]);
    }

    private
    function getImagesIdByName($imageName): ?Images
    {
        $images = Images::where('name', $imageName)->get()->first();
        return $images;
    }

    private
    function getGroupIdByName($groupName): ?Groups
    {
        $group = Groups::where('name', $groupName)->get()->first();
        return $group;
    }

    private
    function getOptionsOfGroupsByUserId($userId): ?string
    {
        $group = Groups::where(['user_id' => $userId, 'type' => 'Image'])->get();

        $options = [];
        //convert $group to json
        foreach ($group as $value) {
            $option['value'] = $value->name;
            $option['text'] = $value->name;
            $options[] = $option;
        }

        return count($options) == 0 ? null : json_encode($options);
    }

    private
    function getOptionsOfGroupsByimageId($imagesId): ?string
    {
        $groups = DB::table('image_group')
            ->join('groups', 'image_group.group_id', '=', 'groups.id')
            ->where('image_group.image_id', $imagesId)
            ->where('groups.type', 'Image')
            ->get();

        $option = [];
        //convert $group to json
        foreach ($groups as $value) {
            $option[] = $value->name;
        }

        return count($option) == 0 ? null : json_encode($option);
    }

    /**
     * need to re-assemble the url from the query strings
     *
     * @param Request $request
     * @return string
     * @see images.js::getUrlFromQueryStrings()
     *
     */
    private
    function createUrlFromQueryStrings($request)
    {
        $domain = $request->input('scheme') . "://" . $request->input('host');
        $directory = $request->input('dirname');
        $fileName = $request->input('file') . '.' . $request->input('ext');

        return $domain . $directory . '/' . $fileName;
    }
}
