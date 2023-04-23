<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suffixes;
use App\Models\Groups;
use Illuminate\Support\Facades\DB;

class SuffixListController extends Controller
{
    function view()
    {
        $user = auth()->user();
        $suffixes = Suffixes::all()->where('user_id', $user->id);
        $groups = Groups::where('user_id', $user->id)
            ->where('groups.type', 'Suffix')
            ->get();

        return view('modals.suffixList', [
            'suffixes' => $suffixes,
            'groups' => $groups,
        ]);
    }

    function viewSuffixes($groupId = null)
    {
        $user = auth()->user();

        $suffixesQuery = DB::table('suffixes')
            ->join('suffix_group', 'suffixes.id', '=', 'suffix_group.suffix_id')
            ->join('groups', 'groups.id', '=', 'suffix_group.group_id')
            ->where('groups.type', 'Suffix')
            ->where('suffixes.user_id', $user->id);

        if ($groupId !== null && $groupId !== 'all') {
            $suffixesQuery->where('suffix_group.group_id', $groupId);
        }

        $suffixes = $suffixesQuery->get();

        return response()->json(['success' => true, 'suffixes' => $suffixes]);
    }
}