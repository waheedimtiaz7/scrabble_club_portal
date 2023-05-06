<?php

namespace App\Observers;

use App\Models\Member;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function created(Member $member)
    {
        $member->recordEvent('member_created', $member->toArray());
    }

    /**
     * Handle the Member "updated" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function updated(Member $member)
    {
        $updatedAttributes = $member->getDirty();
        $updatedValues = [];
        foreach ($updatedAttributes as $key => $value) {
            $updatedValues[$key] = $member->getOriginal($key);
        }
        $member->recordEvent('member_updated', $member->getChanges(), $updatedValues);
    }

    /**
     * Handle the Member "deleted" event.
     *
     * @param  \App\Models\Member  $member
     * @return void
     */
    public function deleted(Member $member)
    {
        $member->recordEvent('member_deleted');
    }

}
