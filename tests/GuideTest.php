<?php

class GuideTest extends TestCase
{
    public function test_guest_have_access()
    {
        $this->visit(route('resources.guides.index'));
    }
}
