<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\Khoa;
use Tests\TestCase;



class TestKhoa extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $khoa = Khoa::factory()->create();
        $respone=$this->post('/admin/khoa/add',[
            'MaKhoa' => 'CNTT',
             'TenKhoa' => "Công nghệ thông tin"
        ]);
        $this->assertCount(3,Khoa::all());
        //$this->assertTrue(true);
    }
    
}
