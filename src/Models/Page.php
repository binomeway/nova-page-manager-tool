<?php


namespace BinomeWay\NovaPageManagerTool\Models;

use BinomeWay\NovaPageManagerTool\Casts\BlocksFlexibleCast;
use BinomeWay\NovaPageManagerTool\Contracts\InteractsWithUrlBuilder;
use BinomeWay\NovaPageManagerTool\Tags\PagePositionsTag;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use BinomeWay\NovaPageManagerTool\Traits\HasUrlBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

/**
 * Class Page
 * @package BinomeWay\NovaPageManagerTool\Models
 * @property-read Tag $status
 */
class Page extends Model implements Sortable, InteractsWithUrlBuilder, HasMedia
{
    use HasFactory, HasTags, HasFlexible, SortableTrait, HasUrlBuilder, InteractsWithMedia;

    const STATUS_PUBLISHED = 'Published';
    const STATUS_DRAFT = 'Draft';

    protected $fillable = ['status', 'positions'];

    protected $casts = [
        'blocks' => BlocksFlexibleCast::class,
    ];

    public function getTable()
    {
        return config('nova-page-manager-tool.pages_table_name');
    }

    /**
     * @param $status
     * @return bool
     * @deprecated
     */
    public function isStatus($status): bool
    {
        $givenStatus = $this->status->name;

        return $givenStatus === $status;
    }

    public function isPublished(): bool
    {
        return $this->status->name === self::STATUS_PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status->name === self::STATUS_DRAFT;
    }

    public function getStatusAttribute()
    {
        return $this->tagsWithType(PageStatusTag::NAME)->first() ?? new Tag();
    }

    public function scopeWherePositions($query, array $positions, string $tagType = PagePositionsTag::NAME)
    {
        return $query->withAnyTags($positions, $tagType);
    }

    public function scopeWhereStatus($query, array $statuses, string $tagType = PageStatusTag::NAME)
    {
        return $query->withAnyTags($statuses, $tagType);
    }

    public function scopePublished($query)
    {
        return $query->withAnyTags([self::STATUS_PUBLISHED], PageStatusTag::NAME);
    }

    public function scopeDraft($query)
    {
        return $query->withAnyTags([self::STATUS_DRAFT], PageStatusTag::NAME);
    }
}
