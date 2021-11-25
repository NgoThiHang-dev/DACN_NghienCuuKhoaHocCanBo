<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response=$this->get('/');
    //     $response->assertStatus(200);
    // }

    public function test_login()
    {
        $response=$this->get('/login');
        $response->assertStatus(200);
        $response=$this->post('/login');
        $this->assertTrue(true);
    }

    public function test_admin()
    {
        $response=$this->get('/admin/home');
        $response->assertStatus(302);
    }

    public function test_user()
    {
        $response=$this->get('/user');
        $response->assertStatus(200);
    }


    public function test_khoa()
    {
        $response=$this->get('admin/khoa');
        // $response=$this->get('admin/khoa/add');
        $response->assertStatus(302);
        // $response=$this->post('admin/khoa/index');
        // $response=$this->post('admin/khoa/add');
        $this->assertTrue(true);
    }

    public function test_giangvien()
    {
        $response=$this->get('/admin/giangvien/index');
        $response=$this->get('/admin/giangvien/add');
        $response->assertStatus(302);
        $response=$this->post('/admin/giangvien/index');
        $response=$this->post('/admin/giangvien/add');
        $this->assertTrue(true);
    }


    public function test_loaidetai()
    {
        $response=$this->get('/admin/loaidetai/index');
        $response=$this->get('/admin/loaidetai/add');
        $response->assertStatus(302);
        $response=$this->post('/admin/loaidetai/index');
        $response=$this->post('/admin/loaidetai/add');
        $this->assertTrue(true);
    }



}
