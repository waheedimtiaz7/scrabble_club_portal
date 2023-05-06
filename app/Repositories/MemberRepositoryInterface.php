<?php

namespace App\Repositories;

use App\Models\Member;

interface MemberRepositoryInterface
{
    /**
     * Create a new member.
     *
     * @param array $data
     * @return Member
     */
    public function create(array $data): Member;

    /**
     * Update an existing member.
     *
     * @param int $id
     * @param array $data
     * @return Member
     */
    public function update(int $id, array $data): Member;


    /**
     * Get a member by their ID.
     *
     * @param int $id
     * @return Member|null
     */
    public function getById(int $id): ?Member;


}
