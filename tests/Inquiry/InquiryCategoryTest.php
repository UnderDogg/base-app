<?php

namespace App\Tests\Inquiry;

use App\Models\Category;
use App\Tests\TestCase;

class InquiryCategoryTest extends TestCase
{
    public function test_users_cannot_access_categories()
    {
        $this->actingAs($this->createUser());

        $this->get(route('inquiries.categories.index'))
            ->see('403');
    }

    public function test_admins_can_access_categories()
    {
        $this->actingAs($this->createAdmin());

        $this->get(route('inquiries.categories.index'))
            ->see('Categories');
    }

    public function test_create_category()
    {
        $this->actingAs($this->createAdmin());

        $category = [
            'belongs_to'    => 'inquiries',
            'name'          => 'New Category',
        ];

        $this->post(route('inquiries.categories.store'), $category);

        $this->seeInDatabase('categories', $category);
    }

    public function test_create_category_with_manager_required()
    {
        $this->actingAs($this->createAdmin());

        $category = [
            'belongs_to'    => 'inquiries',
            'name'          => 'New Category',
            'manager'       => true,
        ];

        $this->post(route('inquiries.categories.store'), $category);

        unset($category['manager']);

        $this->seeInDatabase('categories', $category);

        $this->assertTrue(Category::whereName('New Category')->first()->manager);
    }

    public function test_create_category_as_child()
    {
        $this->actingAs($this->createAdmin());

        $category = [
            'belongs_to'    => 'inquiries',
            'name'          => 'New Category',
            'parent'        => 1,
        ];

        $this->post(route('inquiries.categories.store'), $category);

        $this->assertEquals(1, Category::whereName('New Category')->first()->parent_id);
    }

    public function test_edit_category()
    {
        $this->test_create_category();

        $category = [
            'belongs_to'    => 'inquiries',
            'name'          => 'Modified Category',
        ];

        $this->patch(route('inquiries.categories.update', [1]), $category);

        $this->seeInDatabase('categories', $category);
    }

    public function test_delete_category()
    {
        $this->test_create_category();

        $category = Category::firstOrFail();

        $this->delete(route('inquiries.categories.destroy', [$category->id]));

        $this->dontSeeInDatabase('categories', ['id' => $category->id]);
    }
}
