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

        $filesQuery = File::where('project_id', $projectId)
            ->where('_lft', '!=', 1);
        if ($search) {
            $filesQuery->where('name', 'like', "%$search%");
        } else {
            $filesQuery->where('parent_id', $folder->id);
        }
        //Transform the result into a JSON response using the FileResource
        //Using Collection Methode to transform multiple records
        $files = FileResource::collection($filesQuery->get());
        $folderResource = new FileResource($folder);

        // For breadcrumb  using the folder's ancestors and the current folder
        // It's build fron kylone 
        //using collection here for transform multiple records
        $ancestors = FileResource::collection([...$folder->ancestors, $folder]);
        if($folderResource->is_folder)
       { return Inertia::render('Projects/Files', [
            'files' => $files,
            'api_token' => $user->api_token,
            'projectName' => Project::findOrFail($projectId)->name,
            'folders' => $folderResource,
            'projectId' => $projectId,
            'ancestors' => $ancestors
       ]);
    }else {
        // If it's a file, return the file data
        return response()->json([
            'file' => new FileResource($folderResource), // Assuming $folderResource contains file data
            'message' => 'File retrieved successfully.',
        ]);
    }
    }
    /**
     * Get the root folder for given project 
     */
    private function getRoot($projectId)
    {
        // Get the root folder for the given project 
        //whereIsRoot() method from the Kalnoy NestedSet package to get the root folder 
        return File::query()->whereIsRoot()->where('project_id', $projectId)->firstOrFail();
    }
    /**
     * Get the parent folder for given folder or file  
     */
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
    /**
     * Create a new folder within the project.
     */
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
        $folder = new File([
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'is_folder' => true,
            'project_id' => $projectId,
            'name' => $request->name,
        ]);
        // Append the new folder as a child of the parent 
        // The appendNode() method from the Kalnoy NestedSet package
        $parent->appendNode($folder);
    }
    /**
     * Update the folder's.
     */
    public function updateFolder(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $parent = $request->parent;
        // Retrieve the folder by its ID
        $folder = File::where('id', $request->id)
            ->where('project_id', $projectId)
            ->firstOrFail();
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
        // Update path and name
        $folder->path = $parent->isRoot()
            ? Str::slug($request->name)
            : $parent->path . '/' . Str::slug($request->name);
        $folder->update([
            'name' => $request->name,
            'updated_by' => auth()->id(),
        ]);
    }
    /**
     * Show file upload form.
     */
    public function showUploadForm($projectId, $folder = null,$fileId=null)
    {

        // find the folder that matches the given path within the project or get the root 
        $folder = $this->getParent($folder, $projectId);
        $ancestors = FileResource::collection([...$folder->ancestors, $folder]);
        $file = File::where('id', $fileId)
        ->where('project_id', $projectId)->firstOrFail(); 
       
           
        return Inertia::render(
            'Projects/UploadFile',
            [
                'breadcrumbs' => $ancestors,
                'folder' => $folder,
                'file'=> $file,
                'projectId' => $projectId
            ]
        );
    }

    /**
     * Handle file upload.
     */
    public function uploadFile(Request $request)
    {
        $uploadedFile = $request->file('file');
        $path = Storage::disk('do')->put('files', $uploadedFile);
        return response()->json([
            'success' => true,
            'file' => [
                'name' => $uploadedFile->getClientOriginalName(),
                'url' => Storage::disk('do')->url($path),
                'mimeType' => $uploadedFile->getClientMimeType(),
                'size' => $uploadedFile->getSize(),
            ],
        ]);
    }
    public function storeFile(StoreFileRequest $request, $projectId)
    {
        // Set the parent folder ID form the request 
        $parent = $request->parent;
        $validated = $request->validated();

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
        $file = new File([
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'project_id' => $projectId,
            'is_folder' => 0,
            'name' => $validated['name'],
            'path' => $validated['path'],
            'size' => $validated['size'],
            'mime' => $validated['mime'],
            'subject' => $validated['subject'],
            'reference_number' => $validated['reference_number'],
            'date' => $validated['date'],
        ]);
        // Append the new folder as a child of the parent 
        $parent->appendNode($file);
        // This for save and upload another feature 
        if ($validated['redirect']) {
            return redirect(route('projects.folder', parameters: ['id' => $projectId, 'folders' => $parent->path,]));
        } else {
            return redirect(route('projects.showUploadForm', parameters: ['id' => $projectId, 'folders' => $parent->path]));
        }

    }
    public function updateFile(  StoreFileRequest $request, $projectId,$fileId)
    {
        // Set the parent folder ID form the request 
        $parent = $request->parent;
         // Validate the request
         $validated = $request->validated();
    

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
        $file = File::where('id', $fileId)
        ->where('project_id', $projectId)
        ->firstOrFail();
        $file->update([
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'project_id' => $projectId,
            'is_folder' => 0,
            'name' => $validated['name'],
            'path' => $validated['path'],
            'size' => $validated['size'],
            'mime' => $validated['mime'],
            'subject' => $validated['subject'],
            'reference_number' => $validated['reference_number'],
            'date' => $validated['date'],

        ]);
        // Append the new folder as a child of the parent 
      

    }
}
