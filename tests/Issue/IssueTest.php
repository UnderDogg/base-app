<?php

namespace App\Tests\Issue;

use App\Models\Issue;
use App\Tests\TestCase;

class IssueTest extends TestCase
{
    public function test_issue_index_regular_user()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('issues.index'))->see('Tickets');
    }

    public function test_issue_index_regular_user_sees_only_their_own_tickets()
    {
        $issue = factory(Issue::class)->create();

        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('issues.index'))
            ->see('There are no records to display.');

        $this->seeInDatabase('issues', ['user_id' => $issue->user_id]);
    }
}
