<?php

namespace App\Domains\Announcement\Models;

use App\Domains\Announcement\Models\Traits\Scope\AnnouncementScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Announcement.
 */
class Announcement extends Model
{
    use AnnouncementScope,
        SoftDeletes;

    public const TYPE_FRONTEND = 'frontend';
    public const TYPE_BACKEND = 'backend';

    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $table = 'announcements';

    /**
     * @var string[]
     */
    protected $fillable = [
        'area',
        'type',
        'message',
        'enabled',
        'starts_at',
        'ends_at',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'starts_at',
        'ends_at',
        'deleted_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $appends = ['starts_at_input', 'ends_at_input'];

    public function getStartsAtInputAttribute()
    {
        if ($this->starts_at == null) {
            return $this->created_at->format('Y-m-d');
        }

        return $this->starts_at->format('Y-m-d');
    }

    public function getEndsAtInputAttribute()
    {
        if ($this->ends_at == null) {
            return null;
        }

        return $this->ends_at->format('Y-m-d');
    }
}
