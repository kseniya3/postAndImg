<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Models\User;
use App\Models\Articl;


class ArticlCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;

    public function testNewUserCreate()
    {
        $user = User::create([
            'name' => 'UserTest',
            'email' => 'emailTest@gmail.com',
            'password' => bcrypt('qwert123')
        ]);
        $role = Role::create(['name' => 'admin']);
        $role->syncPermissions('articl-create');
        $user->assignRole('admin');

    }
//
//    public function testCreatePostWithMiddleware()
//    {
//        $data = [
//            'name' => "Post1",
//            'date' => "2020-08-09 13:59:57",
//            'content' => 'texttexttext'
//        ];
//
//        $response = $this->json('POST', '/articles/create',$data);
//        $response->assertStatus(401);
//        $response->assertJson(['message' => "Unauthenticated."]);
//    }
//
//    public function testCreateProduct()
//    {
//
//        $data = [
//            'name' => "Post1",
//            'date' => "2020-08-09 13:59:57",
//            'content' => 'texttexttext'
//        ];
//
//        $post = factory(Articl::class)->create();
//        $user = factory(User::class)->create();
//        $role = Role::create(['name' => 'admin']);
//        $role->syncPermissions('articl-create');
//        $user->assignRole('admin');
//
//        $response = $this->actingAs($user, 'api')->json('POST', '/articles/create',$data);
//        $response->assertStatus(200);
//        $response->assertJson(['status' => true]);
//        $response->assertJson(['message' => "Product Created!"]);
//        $response->assertJson(['data' => $data]);
//    }

}
