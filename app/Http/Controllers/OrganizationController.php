<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Validation\Rule;

use App\Mail\RegisterInvite;
use Illuminate\Support\Facades\Mail;
class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all organizations along with the count of users in each organization
        $oranizations = Organization::withCount('users')->get();
        return Inertia::render(
            'AdminPanel/Organizations',
            [
                'organizations' => $oranizations,
                'breadcrumbs' => [
                    ['name' => 'Organizations', 'url' => route('organizations')],
                ]
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
    public function store(Request $request, Organization $organization)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('organizations')->ignore($organization->id),
            ],
        ]);
        // Create a new organization with the validated data
        Organization::create($validated);
        // Redirect to the organizations index page to display the updated list
        return redirect(route('organizations'));
    }

    public function showUsers($orgId)
    {
        $organization = Organization::findOrFail($orgId);

        // Find the users associated with the specified organization ID, ordered by latest
        $users = User::where('org_id', $orgId)->latest()->get();
        
        return Inertia::render(
            'AdminPanel/Users',
            [
                'users' => $users,
                'orgId' => $orgId,
                'breadcrumbs' => [
                    ['name' => 'Organizations', 'url' => route('organizations')],
                    ['name' => $organization->name, 'url' => route('organizations.users', $organization->id)],
                ]

            ]
        );

    }
    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
