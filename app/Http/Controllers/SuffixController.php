<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Suffixes;
use App\Models\Groups;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SuffixController extends Controller
{
    /**
     * @param Project $project
     * @param Suffixes $suffix
     * @param Request $request
     * @return View
     */
    public function edit(Project $project, Suffixes $suffix, Request $request): View
    {
        $user = auth()->user();

        $endGracePeriod = null;
        $projectId = $project->id;
        $suffixId = $suffix->id;
        $suffixName = $suffix->name;

        $groupsSelected = $this->getOptionsOfGroupsBysuffixId($suffixId);

        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.suffix', [
            'buttonRow' => null,
            'suffixName' => $suffixName,
            'groupsSelected' => $groupsSelected,
            'suffix' => $suffix->suffix,
            'projectId' => $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    /**
     * @param Project $project
     * @param Request $request
     * @return View
     */
    public function view(Project $project, Request $request): view
    {
        $user = auth()->user();
        $plan = $user->getPlanFromUserSubscription();
        $projectId = $project->id;

        $suffix = $request->input('suffix') ?? null;
        $buttonRow = $request->input('rowId') ?? null;
        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.suffix', [
            'buttonRow' => $buttonRow,
            'suffixName' => '',
            'suffix' => $suffix,
            'projectId' => $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {

        $user = auth()->user();

        //get the suffix id by name
        $suffix = $this->getSuffixesIdByName($request->input('title'));
        $groupList = null;
        if ($suffix instanceof Suffixes) {
            //get a list of groups that the suffix is already in
            $groupList = Groups::join('suffix_group', 'groups.id', '=', 'suffix_group.group_id')
                ->where('groups.user_id', $user->id)
                ->where('suffix_group.suffix_id', $suffix->id)
                ->select('groups.*') // Optional: Select only the 'groups' table columns
                ->get();
        }

        //get the list of groups that we want to add the suffix to
        $groups = explode('-::-', $request->input('group'));

        //loop through the list of groups and add the suffix to each group
        foreach ($groups as $groupStr) {

            //get the group id by name
            $group = $this->getGroupIdByName($groupStr);

            //check if the suffix and group are already in the suffix_group table and if they are, skip it
            if ($suffix instanceof Suffixes && $group instanceof Groups) {
                DB::table('suffix_group')->insertOrIgnore(['suffix_id' => $suffix->id, 'group_id' => $group->id]);
                continue;
            }

            //if we don't have a suffix or group, create them
            $suffix = $suffix ?? new Suffixes();
            $group = $group ?? new Groups();

            //save the suffix
            $suffix->name = $request->input('title') ?? null;
            $suffix->suffix = $request->input('suffix') ?? null;
            $suffix->user_id = $user->id;
            $suffix->save();

            //if we have a groupList, check if the group exists
            if($groupList !== null) {
                //save the group if it doesn't exist in the groups table
                if ($groupList->contains('name', $groupStr) === false) {
                    $group->name = $groupStr;
                    $group->type = 'Suffix';
                    $group->user_id = $user->id;
                    $group->save();
                } else {
                    //if the group does exist, get the group object
                    $group = $groupList->where('name', $groupStr)->first();
                }
            }
            //add the suffix to the group
            $suffix->groups()->attach($group->id);
        }

        //if we have a groupList.
        if ($groupList) {
            // need to check if any groups is being removed and remove them from the suffix_group table if they have
            $groupsToRemove = [];
            foreach ($groupList as $group) {
                if (in_array($group->name, $groups) === false) {
                    $groupsToRemove[] = $group->id;
                }
            }
            // if we find groups that need to be removed, remove them
            if ($groupsToRemove !== []) {
                DB::table('suffix_group')->whereIn('group_id', $groupsToRemove)->delete();
            }
        }

        return response()->json(['success' => true, 'suffixId' => $suffix->id]);
    }

    /**
     * @param $suffixName
     * @return Suffixes|null
     */
    private function getSuffixesIdByName($suffixName): ?Suffixes
    {
        $suffix = Suffixes::where('name', $suffixName)->get()->first();
        return $suffix;
    }

    /**
     * @param $groupName
     * @return Groups|null
     */
    private function getGroupIdByName($groupName): ?Groups
    {
        $group = Groups::where('name', $groupName)->get()->first();
        return $group;
    }

    /**
     * @param $userId
     * @return string|null
     */
    private function getOptionsOfGroupsByUserId($userId): ?string
    {
        $group = Groups::where(['user_id' => $userId, 'type' => 'Suffix'])->get();

        $options = [];
        //convert $group to json
        foreach ($group as $value) {
            $option['value'] = $value->name;
            $option['text'] = $value->name;
            $options[] = $option;
        }

        return count($options) == 0 ? null : json_encode($options);
    }

    /**
     * @param $suffixId
     * @return string|null
     */
    private function getOptionsOfGroupsBysuffixId($suffixId): ?string
    {
        $groups = DB::table('suffix_group')
            ->join('groups', 'suffix_group.group_id', '=', 'groups.id')
            ->where('suffix_group.suffix_id', $suffixId)
            ->where('groups.type', 'Suffix')
            ->get();

        $option = [];
        //convert $group to json
        foreach ($groups as $value) {
            $option[] = $value->name;
        }

        return count($option) == 0 ? null : json_encode($option);
    }
}
