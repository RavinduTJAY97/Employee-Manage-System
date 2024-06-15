<?php

namespace App\Http\Repositories;

use App\Models\AccuraMember;
use Illuminate\Http\Request;

class AccuraMemberRepository
{
    public function __construct(AccuraMember $accuraMember)
    {
        $this->accuraMember = $accuraMember;
    }
    public function memberList(Request $request)
    {
        return  $this->accuraMember->with('division')->get();

    }

    public function memberById($memberId)
    {
        return  $this->accuraMember->find($memberId);

    }

    public function addMember($request)
    {
        return  $this->accuraMember->create($request);

    }

    public function updateMember($request, $memberId)
    {
        $member = $this->accuraMember->find($memberId);
        return $member->update($request);

    }

    public function removeMember($memberId)
    {
        $member = $this->accuraMember->find($memberId);
        return  $member->delete();

    }

}
