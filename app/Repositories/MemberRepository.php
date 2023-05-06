<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class MemberRepository implements MemberRepositoryInterface
{
    /**
     * @var Member
     */
    protected $model;

    /**
     * MemberRepository constructor.
     *
     * @param Member $model
     */
    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    /**
     * Get all members.
     *
     * @return LengthAwarePaginator
     */
    public function getAllMembers(): LengthAwarePaginator
    {
        return $this->model->paginate(10);
    }

    /**
     * Get a member by ID.
     *
     * @param int $id The ID of the member.
     *
     * @return Member|null
     */
    public function getById(int $id): ?Member
    {
        $member = Member::find($id);

        return $member;
    }

    /**
     * Create a new member.
     *
     * @param array $data The data for the new member.
     *
     * @return Member
     */
    public function create(array $data): Member
    {
        return $this->model->create($data);
    }

    /**
     * Update a member by ID.
     *
     * @param int $id The ID of the member to update.
     * @param array $data The updated data for the member.
     *
     * @return bool
     */
    public function update(int $id, array $data): Member
    {
        $member = $this->model->find($id);
        $member->fill($data)->save();
        return $member;
    }

    /**
     * Delete a member by ID.
     *
     * @param int $id The ID of the member to delete.
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    /**
     *
     * @return array
     */
    public function getTopScoringMembers($minimumGamesPlayed = 10, $limit = 10)
    {
        $members = Member::has('gameMember', '>=', $minimumGamesPlayed)
            ->withCount(['gameMember as average_total_score' => function ($query) use ($limit) {
                $query->select(\DB::raw('avg(member_total_score) as average_score'))
                    ->groupBy('member_id')
                    ->orderByDesc('average_score')
                    ->take($limit);
            }])
            ->take($limit)
            ->orderByDesc('average_total_score')
            ->get();
        return $members;
    }

    /**
     * Get a member by ID.
     *
     * @param Member $member = The ID of the member.
     *
     * @return array|null
     */
    public function getStats($member): ?array
    {

        // Get highest score
        if($member->gameMember()->count()){
            $highestScore = $member->gameMember()->orderByDesc('member_total_score')->first();

            // Get opponents in highest score
            $opponent = $highestScore->game->opponentOf($member);

            // Get the number of wins
            $wins = $member->games()->where('winner_id', $member->id)->count();

            // Get the number of losses
            $losses = $member->games()->where('winner_id', '<>', $member->id)->count();

            // Get the average score
            $averageScore = $member->gameMember()->avg('member_total_score');
        }


        return $gameDetails = [
            'highest_score' => $highestScore->member_total_score??0,
            'date' => $highestScore->game->date??0,
            'opponent' => $opponent->name??'',
            'wins' => $wins??0,
            'losses' => $losses??0,
            'averageScore' => $averageScore??0,
        ];
    }
}
