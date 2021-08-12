<?php


namespace BinomeWay\NovaPageManagerTool\Nova\Actions;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BooleanGroup;
use Spatie\Tags\Tag;

class UpdateTag extends Action
{
    use InteractsWithQueue, Queueable;

    protected string $tagType;
    protected string $fieldLabel;

    public function __construct(string $tagType, string $fieldLabel = 'Tags')
    {
        $this->tagType = $tagType;
        $this->fieldLabel = (string) __($fieldLabel);
    }


    public function withFieldLabel($label)
    {
        $this->fieldLabel = $label;

        return $this;
    }


    public function withName(string $name)
    {
        $this->name = $name;

        return $this;
    }


    public function name()
    {
        return  $this->name ?? __('Update :name', ['name' => $this->fieldLabel]) ;
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        //TODO: use only the tag display
        $models->each(function ($model) use ($fields) {
            $tags = collect($fields->get('tags'))->filter()->keys()->toArray();
            $model->syncTagsWithType($tags, $this->tagType);
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $options = Tag::getWithType($this->tagType)->pluck('name');

        return [
            BooleanGroup::make($this->fieldLabel, 'tags')
                ->options($options),
        ];
    }
}
