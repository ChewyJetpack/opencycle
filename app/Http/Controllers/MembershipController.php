<?php

namespace Opencycle\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Opencycle\Group;
use Opencycle\Http\Requests\Memberships\UpdateMembershipRequest;

class MembershipController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function store(Group $group)
    {
        $user = Auth::user();
        $user->groups()->attach($group);

        return redirect()->back()->with('success', 'You have joined this group');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('memberships.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMembershipRequest $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembershipRequest $request, Group $group)
    {
        Auth::user()->groups()->updateExistingPivot($group->id, $request->all());

        return redirect()->route('groups.show', $group)->with('success', 'Edited group settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $user = Auth::user();
        $user->groups()->detach($group->id);

        return redirect()->back()->with('success', 'You have left the group');
    }
}
