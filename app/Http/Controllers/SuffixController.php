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
    public function edit(Project $project, Suffixes $suffix, Request $request): View
    {
        $user = auth()->user();
        $plan = $user->getSubscriptionPlan();

        $endGracePeriod = null;
        $projectId = $project->id;
        $suffixId = $suffix->id;
        $suffixName = $suffix->name;

        $groupsSelected = $this->getOptionsOfGroupsBysuffixId($suffixId);

        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.suffix', [
            'suffixName' => $suffixName,
            'groupsSelected' => $groupsSelected,
            'suffix' => $suffix->suffix,
            'projectId'=> $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    public function view(Project $project, Request $request): view
    {
        $user = auth()->user();
        $plan = $user->getSubscriptionPlan();
        $projectId = $project->id;

        $suffix = $request->input('suffix')?? null;
        $groupOption = $this->getOptionsOfGroupsByUserId($user->id);

        return view('modals.suffix', [
            'suffixName' => '',
            'suffix' => $suffix,
            'projectId' => $projectId,
            'groupOption' => $groupOption,
        ]);
    }

    public function save(Project $project, Request $request)
    {

        $user = auth()->user();
        // $plan = $user->getSubscriptionPlan();

        //if get suffix id by name id not null and group id not null that check if suffix and group already exist in suffixs and groups table and add if it don't exist
        //else return json response with success true
        if ($this->getSuffixesIdByName($request->input('title')) !== null && $this->getGroupIdByName($request->input('group')) !== null) {
            $suffixs = $this->getSuffixesIdByName($request->input('title'));
            $groups = $this->getGroupIdByName($request->input('group'));
            DB::table('suffix_group')->insertOrIgnore(['suffix_id' => $suffixs, 'group_id' => $groups]);
            return response()->json(['success' => true]);
        }

        $suffixs = new Suffixes();
        $suffixs->name = $request->input('title')?? null;
        $suffixs->suffix = $request->input('suffix')?? null;
        $suffixs->user_id = $user->id;
        $suffixs->save();

        $groupList = Groups::where('user_id', $user->id)->get();

        $groups = explode('|', $request->input('group'));
        foreach($groups AS $groupStr) {
            //check if the $groupStr is already in $groupList and if it is, skip it
            if($groupList->contains('name', $groupStr) === false) {
                $group = new Groups();
                $group->name = $groupStr;
                $group->type = 'Suffix';
                $group->user_id = $user->id;
                $group->save();
            }else{
                $group = $groupList->where('name', $groupStr)->first();
            }


            $suffixs->groups()->attach($group->id);
        }

        return response()->json(['success' => true]);
    }

    private function getSuffixesIdByName($suffixName) : ?Suffixes
    {
        $suffix = Suffixes::where('name', $suffixName)->get()->first();
        return $suffix;
    }

    private function getGroupIdByName($groupName) : ?Groups
    {
        $group = Groups::where('name', $groupName)->get()->first();
        return $group;
    }

    private function getOptionsOfGroupsByUserId($userId) : ?string
    {
        $group = Groups::where(['user_id'=> $userId , 'type'=> 'Suffix'])->get();

        $options = [];
        //convert $group to json
        foreach($group AS  $value) {
            $option['value'] = $value->name;
            $option['text'] = $value->name;
            $options[] = $option;
        }

        return  count($options) == 0 ? null : json_encode($options);
    }

    private function getOptionsOfGroupsBysuffixId($suffixId) : ?string
    {
        $groups = DB::table('suffix_group')
            ->join('groups', 'suffix_group.group_id', '=', 'groups.id')
            ->where('suffix_group.suffix_id', $suffixId)
            ->where('groups.type', 'Suffix')
            ->get();

        $option = [];
        //convert $group to json
        foreach($groups AS  $value) {
            $option[] = $value->name;
        }

        return  count($option) == 0 ? null : json_encode($option);
    }
}
