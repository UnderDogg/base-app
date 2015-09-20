<?php

namespace App\Tests;

use App\Models\Issue;
use App\Models\User;

class IssueTest extends TestCase
{
    public function test_cant_access_issues_without_auth()
    {
        $this->call('GET', route('issues.index'));

        $this->assertRedirectedToRoute('auth.login.index');
    }

    public function test_can_access_issues_with_auth()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->visit(route('issues.index'));

        $this->see('All Issues');
    }

    public function test_access_issues_closed()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->visit(route('issues.closed'));

        $this->see('All Issues');
    }

    public function test_access_issues_create()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->visit(route('issues.create'));

        $this->see('Create an Issue');
    }

    public function test_access_issues_show()
    {
        $issue = factory(Issue::class)->create();

        $this->actingAs($issue->user);

        $this->visit(route('issues.show', [$issue->getKey()]));

        $this->see($issue->title);
    }

    public function test_access_issues_edit()
    {
        $issue = factory(Issue::class)->create();

        $this->actingAs($issue->user);

        $this->visit(route('issues.edit', [$issue->getKey()]));

        $this->see('Edit Issue');
    }
}
