<?php

namespace App\Http\Controllers;
use App\Mail\RegisterInvite;
use Illuminate\Support\Facades\Mail;
use App\Models\invitations;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Organization;

use App\Http\Requests\StoreInvitationRequest;

class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($org_id)
    {
        // Find the organization by ID 
        $organization = Organization::findOrFail($org_id);

        return Inertia::render(
            'AdminPanel/InviteUser',
            [
                'orgId' => $org_id,
                'breadcrumbs' => [
                    ['name' => 'Organizations', 'url' => route('organizations')],
                    ['name' => $organization->name, 'url' => route('organizations.users', $organization->id)],
                    ['name' => 'Invite User', 'url' => route('organizations.createUsers', $organization->id)],

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
    public function store(StoreInvitationRequest $request, $orgId)
    {
        // StoreInvitationRequest class validates the request data  This wa
        // Create a new invitation instance with all request data which validate by StoreInvitationRequest
        $invitation = new Invitations($request->all());

        // Associate the invitation with the specified organization
        $invitation->org_id = $orgId;

        // Generate a unique invitation token
        $invitation->generateInvitationToken();

        // Generate the URL for the invitation
        $url = $invitation->getLink();

        // Save the invitation record to the database
        $invitation->save();

        // Send an invitation email to the provided address
        Mail::to($request->email)->send(new RegisterInvite($invitation->invitation_token, $invitation->org_id, $url,$invitation->role));

        return redirect('organizations.users');

    }

    /**
     * Display the specified resource.
     */
    public function show(invitations $invitations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invitations $invitations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invitations $invitations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invitations $invitations)
    {
        //
    }
}
