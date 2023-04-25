<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PromptHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $usersPlan = $user->getUsersPlan();
        $projects = $user->projects()->get();

        if($usersPlan == 'Tester' && $projects->count() == 0) {
            $addButton = true;
        } else if($usersPlan == 'User' && $projects->count() <= 9) {
            $addButton = true;
        } else if($usersPlan == 'Professional') {
            $addButton = true;
        } else {
            $addButton = false;
        }

        return view('projects.index', [
            'projects' => $projects,
            'addButton' => $addButton,
        ]);
    }

    public function add()
    {
        return view('projects.add');
    }

    public function edit($project_Id, Request $request)
    {
        $id = $request->input('project_id');

        $project = Project::findOrFail($project_Id);

        return view('projects.edit', [
            'project' => $project,
        ]);

    }

    public function save(Request $request)
    {

        $user = auth()->user();
        $projectId = $request->input('project_id');

        if ($projectId) {
            $project = Project::find($projectId);
            $project->user_id = $user->id;
            $project->name = $request->input('name');
            $project->description = $request->input('description');
            // update other fields as necessary
            $project->save();
        } else {
            $project = new Project();
            $project->user_id = $user->id;
            $project->name = $request->input('name');
            $project->description = $request->input('description');
            // set other fields as necessary
            $project->save();
        }

        return view('projects.success');
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Record deleted successfully']);
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
