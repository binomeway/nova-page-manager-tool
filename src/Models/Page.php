<?php


namespace BinomeWay\NovaPageManagerTool\Models;

use BinomeWay\NovaPageManagerTool\Tags\PagePositionsTag;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use BinomeWay\NovaPageManagerTool\Database\Factories\PageFactory;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Page extends Model implements Sortable
{
    use HasFactory, HasTags, HasFlexible, SortableTrait;

    const STATUS_PUBLISHED = 'Published';
    const STATUS_DRAFT = 'Draft';

    protected $fillable = ['status', 'positions'];

    protected $casts = [
        'blocks' => FlexibleCast::class,
    ];

    public function getTable()
    {
        return config('nova-page-manager-tool.pages_table_name');
    }

    public function url($args = []): string
    {
        // TODO: Build the correct url path
        return env('APP_URL') . '/' . $this->slug;
    }


    /**
     * @deprecated
     * @param $status
     * @return bool
     */
    public function isStatus($status): bool
    {
        // TODO: Refactor to use spatie/tags
        return $this->status === $status;
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
