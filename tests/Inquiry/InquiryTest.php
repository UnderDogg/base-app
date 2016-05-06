<?php

namespace App\Tests\Inquiry;

use App\Tests\TestCase;

class InquiryTest extends TestCase
{
    public function test_inquiries()
    {
        $this->actingAs($this->createUser());

        $this->visit(route('inquiries.index'))->see('Requests');
    }

    public function test_create_inquiry()
    {
        $this->actingAs($this->createUser());

        $inquiry = [
            'title'         => 'Request title',
            'description'   => 'Request description',
        ];

        $this->post(route('inquiries.store', [1]), $inquiry);

        $this->seeInDatabase('inquiries', $inquiry);
    }

    public function test_edit_inquiry()
    {
        $this->test_create_inquiry();

        $inquiry = [
            'title'         => 'New title',
            'description'   => 'Request description',
        ];

        $this->patch(route('inquiries.update', [1, 1]), $inquiry);

        $this->seeInDatabase('inquiries', $inquiry);
    }

    public function test_delete_inquiry()
    {
        $this->test_create_inquiry();

        $this->delete(route('inquiries.destroy', [1, 1]));

        $this->dontSeeInDatabase('inquiries', ['id' => 1]);
    }

    public function test_admins_can_view_inquiries()
    {
        $this->test_create_inquiry();

        $this->actingAs($this->createAdmin());

        $this->visit(route('inquiries.show', [1]))
            ->see('Request Title');
    }

    public function test_admins_can_edit_inquiries()
    {
        $this->test_create_inquiry();

        $this->actingAs($this->createAdmin());

        $this->visit(route('inquiries.show', [1]))
            ->see('Request Title');
    }
}
