<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PromptHistory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects()->get();
        return view('projects', ['projects' => $projects]);
    }

    public function updatePromptHistory(Request $request, Project $project)
    {
        // Get the description from the request
        $prompt = $request->input('promptText');
        $basicparams = json_encode($request->input('promptParams.basicParams'));
        $modelparams = json_encode( $request->input('promptParams.modelParams'));
        $upscalerparams = json_encode($request->input('promptParams.upscalerParams'));

        $suffix = json_encode($request->input('suffix'));
        $images = json_encode($request->input('images'));

        // If all are null don't try putting in the database just return a success
        if($prompt == null && $basicparams == null && $modelparams == null && $upscalerparams == null && $suffix == null || $images == null) {
            return response()->json(['success' => true]);
        }

        // Create a new prompt history for the project
        $promptHistory = new PromptHistory();
        $promptHistory->prompt = $prompt;
        $promptHistory->basic_params = $basicparams;
        $promptHistory->model_params = $modelparams;
        $promptHistory->upscale_params = $upscalerparams;
        $promptHistory->suffix = $suffix;
        $promptHistory->images = $images;
        $promptHistory->project_id = $project->id;
        $promptHistory->save();

        // Return a JSON response indicating success or failure
        return response()->json(['success' => true]);
    }
}
