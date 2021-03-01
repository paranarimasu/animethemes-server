<?php

namespace Tests\Feature\Events;

use App\Events\Pivot\AnimeResource\AnimeResourceCreated;
use App\Events\Pivot\AnimeResource\AnimeResourceDeleted;
use App\Events\Pivot\AnimeResource\AnimeResourceUpdated;
use App\Models\Anime;
use App\Models\ExternalResource;
use App\Pivots\AnimeResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AnimeResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * When an Anime is attached to a Resource or vice versa, an AnimeResourceCreated event shall be dispatched.
     *
     * @return void
     */
    public function testAnimeResourceCreatedEventDispatched()
    {
        Event::fake();

        $anime = Anime::factory()->create();
        $resource = ExternalResource::factory()->create();

        $anime->externalResources()->attach($resource);

        Event::assertDispatched(AnimeResourceCreated::class);
    }

    /**
     * When an Anime is detached from a Resource or vice versa, an AnimeResourceDeleted event shall be dispatched.
     *
     * @return void
     */
    public function testAnimeResourceDeletedEventDispatched()
    {
        Event::fake();

        $anime = Anime::factory()->create();
        $resource = ExternalResource::factory()->create();

        $anime->externalResources()->attach($resource);
        $anime->externalResources()->detach($resource);

        Event::assertDispatched(AnimeResourceDeleted::class);
    }

    /**
     * When an Anime Resource pivot is updated, an AnimeResourceUpdated event shall be dispatched.
     *
     * @return void
     */
    public function testAnimeResourceUpdatedEventDispatched()
    {
        Event::fake();

        $anime = Anime::factory()->create();
        $resource = ExternalResource::factory()->create();

        $anime_resource = AnimeResource::factory()
            ->for($anime, 'anime')
            ->for($resource, 'resource')
            ->create();

        $changes = AnimeResource::factory()
            ->for($anime, 'anime')
            ->for($resource, 'resource')
            ->make();

        $anime_resource->fill($changes->getAttributes());
        $anime_resource->save();

        Event::assertDispatched(AnimeResourceUpdated::class);
    }
}