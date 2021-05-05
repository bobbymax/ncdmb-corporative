<?php


namespace App\Helpers;

use App\Models\User;

class MemberDeduction
{
    private $member;

    public function __construct(User $member)
    {
        $this->member = $member;
    }
}
