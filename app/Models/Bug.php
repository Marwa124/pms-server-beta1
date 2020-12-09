<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ProjectManagement\Entities\Project;
use Modules\ProjectManagement\Entities\Task;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class Bug extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'bugs';

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'issue_no',
        'project_id',
        'opportunities_id',
        'task_id',
        'name',
        'description',
        'status',
        'notes',
        'priority',
        'severity',
        'reproducibility',
        'reporter',
        'client_visible',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function opportunities()
    {
        return $this->belongsTo(Opportunity::class, 'opportunities_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
