<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreFileRequest;
use App\Models\Project;
use Inertia\Inertia;
use Illuminate\Support\Str;

use App\Models\File;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Resources\FileResource;
use Storage;
class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $projectId, $folder = null)
    {
        //generate api token for search to 
        $user = Auth::user();
        if (!$user->api_token) {
            $token = JWTAuth::fromUser($user);
            $user->api_token = $token;
            $user->save();
        }
        // find the folder that matches the given path within the project or get the root 
        $search = $request->get('search');
        $folder = $this->getParent($folder, $projectId);

        // Get the files belonging to the project where the parent folder ID matches the current folder's ID
        // Exclude the root folder from the results by filtering `_lft != 1` whic we created when creat the project 

        $files = File::query()
            ->select('files.*')
            ->where('project_id', $projectId)
            ->where('_lft', '!=', 1);
        if ($search) {
            $files->where('name', 'like', "%$search%");
        } else {
            $files->where('parent_id', $folder->id);
        }


        //Transform the result into a JSON response using the FileResource
        //Using Collection Methode to transform multiple records
        $files = FileResource::collection($files->get());
        $folder = new FileResource($folder);

        // For breadcrumb  using the folder's ancestors and the current folder
        // It's build fron kylone 
        //using collection here for transform multiple records
        $ancestors = FileResource::collection([...$folder->ancestors, $folder]);
        //Get the project Name 
        $projectName = Project::findOrFail($projectId);

        return Inertia::render('Projects/Files', [
            'files' => $files,
            'api_token' => $user->api_token,
            'projectName' => $projectName->name,
            'folders' => $folder,
            'projectId' => $projectId,
            'ancestors' => $ancestors
        ]);
    }

    private function getRoot($projectId)
    {
        // Get the root folder for the given project 
        //whereIsRoot() method from the Kalnoy NestedSet package to get the root folder 
        return File::query()->whereIsRoot()->where('project_id', $projectId)->firstOrFail();
    }
    private function getParent($folder, $projectId)
    {
        // If a folder path is provided, find the folder that matches the given path within the project
        if ($folder) {
            $folder = File::query()
                ->where('path', $folder)
                ->where('project_id', $projectId)
                ->firstOrFail();
        }
        // If no folder path is provided, get the root folder for the specified project
        if (!$folder) {
            $folder = $this->getRoot($projectId);
        }
        return $folder;
    }

    public function createFolder(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required',
        ]);
        // Set the parent folder ID form the request 
        $parent = $request->parent;

        // Check if a parent folder is specified
        if (!$parent) {
            //If no parent Id is provided  ,that mean it's not a subfolder so get the root folder for the given project .
            $parent = $this->getRoot($projectId);

        } else {
            // If a parent id is provided find the parent folder by Id 
            $parent = File::where('id', $parent)
                ->where('project_id', $projectId)
                ->firstOrFail();
        }

        // Create a new instance of the File model 
        $file = new File();
        $file->created_by = auth()->user()->id;
        $file->updated_by = auth()->user()->id;
        $file->is_folder = 1;
        $file->project_id = $projectId;
        $file->name = $request['name'];

        // Append the new folder as a child of the parent 
        // The appendNode() method from the Kalnoy NestedSet package

        $parent->appendNode($file);
    }

    public function updateFolder(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $id = $request->id;
        $parent = $request->parent;

      // Check if a parent folder is specified
      if (!$parent) {
        //If no parent Id is provided  ,that mean it's not a subfolder so get the root folder for the given project .
        $parent = $this->getRoot($projectId);

    } else {
        // If a parent id is provided find the parent folder by Id 
        $parent = File::where('id', $parent)
            ->where('project_id', $projectId)
            ->firstOrFail();
    }
        // Retrieve the folder by its ID
        $folder = File::where('id', $id)
            ->where('project_id', $projectId)
            ->firstOrFail();
            if ($parent->isRoot()) {
                $folder->path = Str::slug($request->name);
            } else {
                $folder->path = $parent->path . '/' . Str::slug($request->name);
            }

        $folder->name = $request->name;
        $folder->updated_by = auth()->user()->id;
        $folder->update();



    }

    public function showUploadForm($projectId, $folder = null)
    {
        // find the folder that matches the given path within the project or get the root 
        $folder = $this->getParent($folder, $projectId);
        $ancestors = FileResource::collection([...$folder->ancestors, $folder]);
        return Inertia::render(
            'Projects/UploadFile',
            [
                'breadcrumbs' => $ancestors,
                'folder' => $folder,
                'projectId' => $projectId
            ]

        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('files', 'do');
        Storage::disk('do')->put('files', $file);
        $fileMimeType = $file->getClientMimeType();
        $fileSize = $file->getSize();
        $fileUrl = Storage::disk('do')->url($path);
        return response()->json([
            'success' => true,
            'file' => [
                'name' => $file->getClientOriginalName(),
                'url' => $fileUrl,
                'mimeType' => $fileMimeType,
                'size' => $fileSize
            ]
        ]);
    }
    public function storeFile(StoreFileRequest $request, $projectId)
    {
        // Set the parent folder ID form the request 
        $parent = $request->parent;
        $request = $request->validated();

        // Check if a parent folder is specified
        if (!$parent) {
            //If no parent Id is provided  ,that mean it's not a subfolder so get the root folder for the given project .
            $parent = $this->getRoot($projectId);

        } else {
            // If a parent id is provided find the parent folder by Id 
            $parent = File::where('id', $parent)
                ->where('project_id', $projectId)
                ->firstOrFail();
        }

        // Create a new instance of the File model 
        $file = new File();
        $file->created_by = auth()->user()->id;
        $file->updated_by = auth()->user()->id;
        $file->is_folder = 0;
        $file->path = $request['path'];
        $file->size = $request['size'];
        $file->mime = $request['mime'];
        $file->subject = $request['subject'];
        $file->refrence_number = $request['refrence_number'];
        $file->date = $request['date'];
        $file->project_id = $projectId;
        $file->name = $request['name'];

        // Append the new folder as a child of the parent 
        $parent->appendNode($file);

        // This for save and upload another feature 
        if ($request['redirect']) {
            return redirect(route('projects.folder', parameters: ['id' => $projectId, 'folders' => $parent->path,]));
        } else {
            return redirect(route('projects.showUploadForm', parameters: ['id' => $projectId, 'folders' => $parent->path]));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('hello');
        // return Inertia::render(
        //     'Projects/Projects',

        // );    
    }



    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
}
