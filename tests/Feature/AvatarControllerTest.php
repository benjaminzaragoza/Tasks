<?php

namespace Tests\Feature;

use App\Avatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /**
     * @test
     */
    public function upload_photo()
    {
        $this->withoutExceptionHandling();
        Storage::fake('local');
        Storage::fake('google');

        $user = $this->login();
        $response = $this->post('/avatar',[
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $response->assertRedirect();

        Storage::disk('local')->assertExists($avatarUrl = 'avatar/' . $user->id . '.jpg');
        Storage::disk('google')->assertExists('/' . $user->id . '.jpg');

        $avatar = Avatar::first();
        $this->assertEquals($avatarUrl, $avatar->url);
        $this->assertNotNull($avatar->user);
        $this->assertEquals($user->id, $avatar->user->id);
        $user = $user->fresh();
//        dd($user->avatar);
        $this->assertNotNull($user->avatar);
        $this->assertEquals($avatarUrl, $user->photo->url);
    }

    /**
     * @test
     */
    public function upload_photo_update()
    {
        $user = $this->login();
        $photoUrl = 'photos/' . $user->id . '.jpg';
        Avatar::create([
            'url' => $photoUrl,
            'user_id' => $user->id
        ]);

        Storage::fake('local');

        $response = $this->post('/photo',[
            'photo' => UploadedFile::fake()->image('photo.jpg')
        ]);
        $response->assertRedirect();

        Storage::disk('local')->assertExists($photoUrl);

        $photo = Avatar::first();
        $this->assertEquals($photoUrl, $photo->url);
        $this->assertNotNull($photo->user);
        $this->assertEquals($user->id, $photo->user->id);
        $user = $user->fresh();
        $this->assertNotNull($user->photo);
        $this->assertEquals($photoUrl, $user->photo->url);
    }

}
