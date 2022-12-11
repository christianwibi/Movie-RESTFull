<?php

namespace Tests\Unit;

use Tests\TestCase;

class DetailOfMovieTest extends TestCase
{
    public function test_listOfMovies()
    {
        $id=1;
        $response = $this->getJson('/Movies/'.$id);
        if($response->getStatusCode()==200){
            $this->assertTrue($response['success']);
        }elseif($response->getStatusCode()==422){
            $this->assertNotTrue($response['success']);
        }
    }
}
