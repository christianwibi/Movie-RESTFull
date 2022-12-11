<?php

namespace Tests\Unit;

use Tests\TestCase;

class UpdateMovieTest extends TestCase
{
    public function test_updateMovie()
    {
        $params=[
                "id" => 1,
                "title" =>"Pengabdi Setan 2 Comunion",
                "description" => "dalah sebuah film horor Indonesia tahun 2022 yang disutradarai dan ditulis oleh Joko Anwar sebagai sekuel dari film tahun 2017, Pengabdi Setan.",
                "rating"=>7.0,
                "image"=>"",
                "created_at"=>"2022-08-01 10:56:31",
                "updated_at"=>"2022-08-13 09:30:23"
        ];
        $response = $this->patchJson('/Movies/1', $params);

        if($response->getStatusCode()==200){
            $this->assertDatabaseHas('movies', $params);
            $this->assertTrue($response['success']);
        }elseif($response->getStatusCode()==422){
            $this->assertNotTrue($response['success']);
        }
    }
}
