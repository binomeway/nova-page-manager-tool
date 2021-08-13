<?php


namespace BinomeWay\NovaPageManagerTool\Models;


use BinomeWay\NovaPageManagerTool\Database\Factories\PageFactory;
use BinomeWay\NovaPageManagerTool\Tags\PageStatusTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Page extends Model
{
    use HasFactory, HasTags, HasFlexible;

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';

    protected $fillable = ['status', 'positions'];

    protected $casts = [
        'meta' => FlexibleCast::class,
    ];

    protected static function newFactory()
    {
        return new PageFactory();
    }


    public function getTable()
    {
        return config('nova-page-manager-tool.pages_table_name');
    }

    public function url($args = []): string
    {
        // TODO: Build the correct url path
        return env('APP_URL') . '/' . $this->slug;
    }


    public function isStatus($status): bool
    {
        // TODO: Refactor to use spatie/tags
        return $this->status === $status;
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
}
