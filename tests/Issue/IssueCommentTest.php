<?php

namespace App\Tests\Issue;

use App\Models\Comment;
use App\Models\Issue;
use App\Tests\TestCase;

class IssueCommentTest extends TestCase
{
    public function test_issue_comment_create()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $issue = factory(Issue::class)->create();

        $response = $this->call('POST', route('issues.comments.store', [$issue->getKey()]), [
            'content' => 'Testing Comment',
        ]);

        $this->assertSessionHas('flash_message.level', 'success');
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_issue_comment_edit()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $comment = factory(Comment::class)->create([
            'user_id' => $user->getKey(),
        ]);

        $issue = factory(Issue::class)->create([
            'user_id' => $user->getKey(),
        ]);

        $issue->comments()->save($comment);

        $response = $this->call('PATCH', route('issues.comments.update', [$issue->getKey(), $comment->getKey()]), [
            'content' => 'Edited content',
        ]);

        $this->assertSessionHas('flash_message.level', 'success');
        $this->assertEquals(302, $response->getStatusCode());
    }
}
