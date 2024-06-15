<?php

namespace App\Http\Services;

use App\Http\Repositories\AccuraMemberRepository;
use App\Http\Repositories\DSDivisionRepository;
use App\Models\DSDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccuraMemberService
{
    public function __construct(
        AccuraMemberRepository $accuraMemberRepository,
        DSDivisionRepository $divisionRepository
    )
    {
        $this->accuraMemberRepository = $accuraMemberRepository;
        $this->divisionRepository = $divisionRepository;
    }

    public function memberList(Request $request)
    {
        $membersList = $this->accuraMemberRepository->memberList($request);
        $accuraMembersList = [];
        foreach ($membersList as $member) {
            $accuraMembersList[] = [
                'id' => $member->id,
                'first_name' => $member->fname,
                'last_name' => $member->lname,
                'date_of_birth' => $member->d_o_b,
                'division' => $member->division->name,
            ];
        }
        return $accuraMembersList;

    }

    public function memberById($memberId)
    {
        $member = $this->accuraMemberRepository->memberById($memberId);
        return $member;

    }

    public function getDivisions(){
        $membersList = $this->divisionRepository->getDivisions();
        return $membersList;
    }

    public function addMember($request){
        // Define validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'division_id' => 'required|integer|exists:d_s_divisions,id',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'summary' => 'required|string',
        ];

        // Define custom messages for validation errors
        $messages = [
            'division_id.exists' => 'Invalid division selected.',
            'date_of_birth.before_or_equal' => 'Date of birth must be before or equal to today.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $request->validate($rules);
        $newMember = ([
            'fname' => $validatedData['first_name'],
            'lname' => $validatedData['last_name'],
            'ds_division_id' => $validatedData['division_id'],
            'd_o_b' => $validatedData['date_of_birth'],
            'summary' => $validatedData['summary'],
        ]);
        if (ctype_upper($validatedData['summary'])) {
            $newMember['lname'] .= ' ' . $validatedData['summary'];
        }
        return $this->accuraMemberRepository->addMember($newMember);
    }

    public function updateMember($request,$memberId){
        // Define validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'division_id' => 'required|integer|exists:d_s_divisions,id',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'summary' => 'required|string',
        ];

        // Define custom messages for validation errors
        $messages = [
            'division_id.exists' => 'Invalid division selected.',
            'date_of_birth.before_or_equal' => 'Date of birth must be before or equal to today.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $request->validate($rules);
        $member = ([
            'fname' => $validatedData['first_name'],
            'lname' => $validatedData['last_name'],
            'ds_division_id' => $validatedData['division_id'],
            'd_o_b' => $validatedData['date_of_birth'],
            'summary' => $validatedData['summary'],
        ]);
        if (ctype_upper($validatedData['summary'])) {
            $member['lname'] .= ' ' . $validatedData['summary'];
        }
        return $this->accuraMemberRepository->updateMember($member,$memberId);


    }
    public function removeMember($memberId){
        return $this->accuraMemberRepository->removeMember($memberId);

    }

}
