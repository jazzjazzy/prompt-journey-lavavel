<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Images;
use App\Models\Groups;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    function view()
    {
        $user = auth()->user();
        $user->accessLevels = $user->getAccessLevels();

        $subscription = $user->isSubscribed();

        if ($subscription === false) {
            return view('dashboard', ['user' => $user]);
        } else {
            $plan = $user->getPlanFromUserSubscription();

            switch ($plan->slug) {
                case 'monthly-user':
                case 'Yearly-user':
                case 'monthly-pro':
                case 'Yearly-pro':
                    return redirect()->route('projects.index');
                default:
                    return view('dashboard', ['user' => $user]);
            }
        }
    }

    function viewUser($project_Id, Request $request){
        $user = auth()->user();
        $user->accessLevels = $user->getAccessLevels();

        return view('dashboard', ['user' => $user, 'projectId' => $project_Id]);
    }
}
