<?php

namespace Tests\Feature;

use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Articl;


class ArticlCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    public function testNewUserCreate()
    {
        $this->withoutMiddleware();
        $user = factory(\App\Models\User::class)->create();

        //$response = $this->actingAs($user)->json('POST', '/admin.store',$data);
        $response = $this->actingAs($user)
            ->post(route('admin.create'),[
                'name' => $this->faker->words(3,true),
                'email' => $this->faker->unique()->email,
                'password' => bcrypt('qwert123'),
                'confirm-password' =>'qwert123',
                ]);


        //$response->assertStatus(200);
        $response->assertRedirect(route('admin.index'));
    }



    public function testCreatePostWithMiddleware()
    {
//        $data = [
//            'name' => "Post1",
//            'date' => "2020-08-09 13:59:57",
//            'content' => 'texttexttext'
//        ];

        //$role = Role::create(['name' => 'admin']);
//        $permission = Permission::create(['name' => 'articl-create', 'guard_name' => 'web']);
//        $role->syncPermissions($permission);
//        $user->assignRole('admin');
//
//        $response = $this->json('POST', '/articles/create',$data);
//        $response->assertStatus(401);
//        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testCreateProduct()
    {
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
    }

}
