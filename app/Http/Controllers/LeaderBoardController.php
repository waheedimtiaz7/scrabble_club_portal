<?php

namespace App\Http\Controllers;

use App\Repositories\MemberRepository;
use Illuminate\Http\Request;

class LeaderBoardController extends Controller
{
    /**
     * The member repository instance.
     *
     * @var MemberRepository
     */
    protected $memberRepository;

    /**
     * Create a new controller instance.
     *
     * @param MemberRepository $memberRepository
     * @return void
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    //
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Returns a array of Members
        $members = $this->memberRepository->getTopScoringMembers();

        return view('leader_board', compact('members'));
    }
}
