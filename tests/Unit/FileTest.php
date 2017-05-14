<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testViewFile()
    {
        //If File Exist
        $response = $this->get('view-file?location=laravel.log&start=true&end=false&pageNumber=0',
            [
                'X-Requested-With' =>'XMLHttpRequest'
            ]);

        $response->assertStatus(200)
            ->assertJson([
               'status' => 'success',
            ]);
        // If File does not exist.
        $response = $this->get('view-file?location=larav.log&start=true&end=false&pageNumber=0',
            [
                'X-Requested-With' =>'XMLHttpRequest'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'error',
            ]);

    }
}
