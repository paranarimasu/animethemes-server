<?php

namespace Tests\Feature\Events;

use App\Events\Video\VideoCreated;
use App\Events\Video\VideoDeleted;
use App\Events\Video\VideoUpdated;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * When a Video is created, a VideoCreated event shall be dispatched.
     *
     * @return void
     */
    public function testVideoCreatedEventDispatched()
    {
        Event::fake();

        Video::factory()->create();

        Event::assertDispatched(VideoCreated::class);
    }

    /**
     * When a Video is deleted, a VideoDeleted event shall be dispatched.
     *
     * @return void
     */
    public function testVideoDeletedEventDispatched()
    {
        Event::fake();

        $video = Video::factory()->create();

        $video->delete();

        Event::assertDispatched(VideoDeleted::class);
    }

    /**
     * When a Video is updated, a VideoUpdated event shall be dispatched.
     *
     * @return void
     */
    public function testVideoUpdatedEventDispatched()
    {
        Event::fake();

        $video = Video::factory()->create();
        $changes = Video::factory()->make();

        $video->fill($changes->getAttributes());
        $video->save();

        Event::assertDispatched(VideoUpdated::class);
    }
}