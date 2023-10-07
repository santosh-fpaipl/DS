<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageMedia;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\ManageTag;
use Fpaipl\Panel\Traits\NamedSlug;
use Fpaipl\Panel\Traits\Authx;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Product;

class Range extends Model 
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        LogsActivity,
        NamedSlug,
        ManageMedia,
        ManageModel,
        ManageTag;

    // Properties

   //const INDEXABLE = false;

    /*
        Auto Generated Columns:
        id
        slug
    */
    protected $fillable = [
        'name', 
        'slug',
        'sid',
        'start_price',
        'end_price',
        'moq',
        'hsncode',
        'gstrate'
    ];
    
    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];
    
    protected $dependency = [];


    public function hasDependency(){
        return count($this->dependency);
    }

    public function getDependency(){
        return $this->dependency;
    }
    // Helper Functions

    // Relationships
    
    public function product(){
        return $this->belongsTo(Product::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                    'id', 
                    'name', 
                    'slug',
                    'sid',
                    'start_price',
                    'end_price',
                    'moq',
                    'hsncode',
                    'gstrate',
                    'created_at', 
                    'updated_at', 
                    'deleted_at'
            ])->useLogName('model_log');
    }
}