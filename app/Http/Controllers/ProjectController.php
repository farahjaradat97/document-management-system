<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProjectResource;
use App\Models\File;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get the current user orgId
        $userOrgId = auth()->user()->org_id;

        // get projects for that organization
        $projects = Project::where('org_id', $userOrgId)->get();
        $projects = ProjectResource::collection($projects);

        
        return Inertia::render(
            'Projects/Projects',
            [
                'projects' => $projects,
                'orgId' => $userOrgId

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'name')
            ],
            'org_id' => [
                'required',
                'integer',
                Rule::exists('organizations', 'id'),
                Rule::in([auth()->user()->org_id]),
            ]


        ]);
        // Create a new organization with the validated data
        $project = Project::create($validated);

        // make the project root file to start uplode and create folder and subfolder or files into this project 
        $file = new File();
        $file->name = $project->name;
        $file->path = route('projects.folder', $project->id);
        $file->project_id = $project->id;
        $file->created_by = auth()->user()->id;
        $file->updated_by = auth()->user()->id;
        $file->is_folder = 1;
        $file->makeRoot()->save();


        // Redirect to the organizations index page to display the updated list
        return redirect(route('projects'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

            ],
        ]);
        $project = Project::findOrFail($project->id,'id' );
        $project->update($validated);

        // Update the project with the validated data
        return redirect(route('projects'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
