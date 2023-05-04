<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    function view(Request $request)
    {

        $user = auth()->user();
        $user->accessLevels = $user->getAccessLevels();
        $projectId = $request->input('project_id');

        $subscription = $user->isSubscribed();

        $plan = $user->getPlanFromUserSubscription();

        if ($subscription === true && $projectId !== null){
            return view('dashboard', [
                'user' => $user,
                'projectId' => $projectId,
                'plan' => $plan,
            ]);
        }else if($subscription === true ) {
            if($plan->name === 'Tester') {
                $project = Project::where('user_id', $user->id)->first();
                return view('dashboard', [
                    'user' => $user,
                    'projectId' => $project->id,
                    'plan' => $plan,
                ]);
            }
            return redirect()->route('projects.index');
        } else {
            return view('dashboard', ['user' => $user]);
        }
    }

    function viewUser($project_Id, Request $request){
        $user = auth()->user();
        $user->accessLevels = $user->getAccessLevels();

        return view('dashboard', ['user' => $user, 'projectId' => $project_Id]);
    }
}
