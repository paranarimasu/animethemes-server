<?php

declare(strict_types=1);

namespace Policies\Admin;

use App\Models\Auth\User;
use App\Policies\Admin\AnnouncementPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

/**
 * Class AnnouncementPolicyTest.
 */
class AnnouncementPolicyTest extends TestCase
{
    use RefreshDatabase;
    use WithoutEvents;

    /**
     * An admin can view any announcement.
     *
     * @return void
     */
    public function testViewAny()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->viewAny($viewer));
        static::assertFalse($policy->viewAny($editor));
        static::assertTrue($policy->viewAny($admin));
    }

    /**
     * An admin can view an announcement.
     *
     * @return void
     */
    public function testView()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->view($viewer));
        static::assertFalse($policy->view($editor));
        static::assertTrue($policy->view($admin));
    }

    /**
     * An admin may create an announcement.
     *
     * @return void
     */
    public function testCreate()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->create($viewer));
        static::assertFalse($policy->create($editor));
        static::assertTrue($policy->create($admin));
    }

    /**
     * An admin may update an announcement.
     *
     * @return void
     */
    public function testUpdate()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->update($viewer));
        static::assertFalse($policy->update($editor));
        static::assertTrue($policy->update($admin));
    }

    /**
     * An admin may delete an announcement.
     *
     * @return void
     */
    public function testDelete()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->delete($viewer));
        static::assertFalse($policy->delete($editor));
        static::assertTrue($policy->delete($admin));
    }

    /**
     * An admin may restore an announcement.
     *
     * @return void
     */
    public function testRestore()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->restore($viewer));
        static::assertFalse($policy->restore($editor));
        static::assertTrue($policy->restore($admin));
    }

    /**
     * An admin may force delete an announcement.
     *
     * @return void
     */
    public function testForceDelete()
    {
        $viewer = User::factory()
            ->withCurrentTeam('viewer')
            ->create();

        $editor = User::factory()
            ->withCurrentTeam('editor')
            ->create();

        $admin = User::factory()
            ->withCurrentTeam('admin')
            ->create();

        $policy = new AnnouncementPolicy();

        static::assertFalse($policy->forceDelete($viewer));
        static::assertFalse($policy->forceDelete($editor));
        static::assertTrue($policy->forceDelete($admin));
    }
}