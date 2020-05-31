<?php

namespace App\Nova\Actions;

use App\Enums\ResourceType;
use App\Models\ExternalResource;
use App\Rules\ResourceTypeDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;

class CreateExternalResourceTypeForArtistAction extends Action
{
    use InteractsWithQueue, Queueable;

    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __('nova.artist_create_resource_action', ['type' => ResourceType::getDescription($this->type)]);
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        // Create Resource Model with link and provided type
        $resource = ExternalResource::create([
            'type' => $this->type,
            'link' => $fields->link
        ]);

        // Check if resource creation is successful
        if (!$resource->exists()) {
            return Action::danger(__('nova.error_resource_creation'));
        }

        // Attach Resource to Anime and provide success message
        $resource->artists()->attach($models);
        return Action::message(__('nova.artist_create_resource_action_success'));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make(__('nova.link'), 'link')
                ->rules('required', 'max:192', 'url', 'unique:resource,link', new ResourceTypeDomain($this->type))
                ->help(__('nova.resource_link_help')),
        ];
    }
}
