<?php


namespace BinomeWay\NovaPageManagerTool\Models;


use BinomeWay\NovaPageManagerTool\Database\Factories\PageFactory;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Page extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTags;

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';

    protected $fillable = ['status', 'positions'];

    protected $casts = [
        'meta' => 'array',
    ];

    protected static function newFactory()
    {
        return new PageFactory();
    }

    public function getTable()
    {
        return config('nova-page-manager-tool.pages_table_name');
    }

    /*public function url($args = []): string
    {
        return route('pages.show', ['page' => $this, ...$args]);
    }*/


    public function isStatus($status): bool
    {
        // TODO: Refactor to use spatie/tags
        return $this->status === $status;
    }

    /**
     * @return array
     * @deprecated Use spatie/tags
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFT => __('Draft'),
            self::STATUS_PUBLISHED => __('Published'), // TODO; Refactor into status tags
        ];
    }

    public function scopeWhereStatus($query, array $statuses, string $tagType = PageStatusTag::NAME)
    {
        return $query->withAnyTags($statuses, $tagType);
    }

    public function scopePublished($query)
    {
        return $query->withAnyTags(['published'], PageStatusTag::NAME);
    }

    public function scopeDraft($query)
    {
        return $query->withAnyTags(['draft'], PageStatusTag::NAME);
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumb')->singleFile();
        $this->addMediaCollection('banner')->singleFile();
    }
}
