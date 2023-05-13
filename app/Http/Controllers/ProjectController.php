<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PromptHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use PDOException;

class ProjectController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        return view('projects.add');
    }

    /**
     * @param $project_Id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($project_Id, Request $request)
    {
        $id = $request->input('project_id');

        $project = Project::findOrFail($project_Id);

        return view('projects.edit', [
            'project' => $project,
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Record deleted successfully']);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePromptHistory(Request $request, Project $project)
    {
        try {
            // Get the description from the request
            $prompt = $request->input('promptText') ?? null;
            $suffix = $request->input('suffix') ?? null;
            $images = $request->input('images') ?? null;

            // If all are null don't try putting in the database just return a success
            if (empty($prompt) && empty($suffix) && empty($images)) {
                return response()->json(['success' => true]);
            }

            // Create a new prompt history for the project
            $promptHistory = new PromptHistory();
            $promptHistory->prompt = $prompt;
            $promptHistory->suffix = $suffix;
            $promptHistory->images = $images;
            $promptHistory->project_id = $project->id;
            $promptHistory->save();

            $promptHistoryResult = PromptHistory::where('project_id', $project->id)->get();

        } catch (PDOException $e) {
            // If there is a database error return a JSON response indicating failure
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        } catch (QueryException $e) {
            // If there is a database error return a JSON response indicating failure
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        // Return a JSON response indicating success or failure
        return response()->json(['success' => true, 'promptHistory' => $promptHistoryResult]);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPromptHistory(Project $project){

        $promptHistory = DB::table('prompt_history')
            ->where('project_id', $project->id)
            ->get();

        return response()->json(['success' => true, 'promptHistory' => $promptHistory]);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearPromptHistory(Project $project){

        $promptHistory = DB::table('prompt_history')
            ->where('project_id', $project->id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
