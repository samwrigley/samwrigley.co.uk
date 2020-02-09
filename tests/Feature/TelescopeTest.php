<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class TelescopeTest extends TestCase
{
    /** @test */
    public function cannot_visit_telescope_dashboard_in_non_local_environments()
    {
        $this->get(route('telescope'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
