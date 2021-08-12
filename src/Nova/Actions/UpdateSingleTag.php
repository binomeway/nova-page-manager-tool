<?php


namespace BinomeWay\NovaPageManagerTool\Nova\Actions;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Select;
use Spatie\Tags\Tag;

class UpdateSingleTag extends UpdateTag
{


    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($model) use ($fields) {
            $model->syncTagsWithType([$fields->get('tag')], $this->tagType);
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $options = Tag::getWithType($this->tagType)->pluck('name', 'name');

        return [
            Select::make($this->fieldLabel, 'tag')
                ->options($options)
                ->required()
                ->searchable(fn() => $options->count() >= 10),
        ];
    }
}
