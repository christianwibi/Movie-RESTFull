<?php

namespace Tests\Unit;

use Tests\TestCase;

class ListOfMovieTest extends TestCase
{
    public function test_listOfMovies()
    {
        $response = $this->getJson('/Movies');
        $response->assertStatus(200);
    }
}
