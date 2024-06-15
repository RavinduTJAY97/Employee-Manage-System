<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Services\AccuraMemberService;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AccuraMemberController extends Controller
{
    /**
     * Constructor to inject AccuraMemberService dependency.
     *
     * @param AccuraMemberService $accuraMemberService
     */
    public function __construct(AccuraMemberService $accuraMemberService)
    {
        $this->accuraMemberService = $accuraMemberService;
    }

    /**
     * Retrieve a list of members.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberList(Request $request)
    {
        try {
            $data = $this->accuraMemberService->memberList($request);
            $response = ['status' => '200', 'message' => 'Accura member-list', 'data' => $data];
            return response()->json($response);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    /**
     * Retrieve details of a member by ID.
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberById($memberId)
    {
        try {
            $data = $this->accuraMemberService->memberById($memberId);
            $response = ['status' => '200', 'message' => 'Member detail', 'data' => $data];
            return response()->json($response);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    /**
     * Retrieve a list of divisions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDivisions()
    {
        try {
            $data = $this->accuraMemberService->getDivisions();
            $response = ['status' => '200', 'message' => 'Division-list', 'data' => $data];
            return response()->json($response);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    /**
     * Add a new member.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMember(Request $request)
    {
        try {
            $data = $this->accuraMemberService->addMember($request);
            $response = ['status' => '200', 'message' => 'Member added successfully', 'data' => $data];
            return response()->json($response);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    /**
     * Update an existing member.
     *
     * @param Request $request
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMember(Request $request, $memberId)
    {
        try {
            $data = $this->accuraMemberService->updateMember($request, $memberId);
            $response = ['status' => '200', 'message' => 'Member updated successfully', 'data' => $data];
            return response()->json($response);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    /**
     * Remove a member.
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeMember($memberId)
    {
        try {
            $data = $this->accuraMemberService->removeMember($memberId);
            $response = ['status' => '200', 'message' => 'Member removed successfully', 'data' => $data];
            return response()->json($response);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
}
