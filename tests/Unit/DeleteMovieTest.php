<?php

namespace Tests\Unit;

use Tests\TestCase;

class DeleteMovieTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_deleteMovie()
    {
        $id= 1;
        $response = $this->deleteJson('/Movies/'.$id);

        if($response->getStatusCode()==200){
            $this->assertDatabaseMissing('movies', ['id'=>$id]);
            $this->assertTrue($response['success']);
        }elseif($response->getStatusCode()==422){
            $this->assertNotTrue($response['success']);
        }
    }
}
