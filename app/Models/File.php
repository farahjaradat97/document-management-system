<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Str;

class File extends Model
{
    // to use the kylone package node methode 
    use NodeTrait;
    use HasFactory;
    protected $fillable = [ 'related_files','path','name', 'created_by','date','is_folder','mime','size','reference_number','subject','updated_by','project_id','parent_id'];
    protected $casts = [
        'related_files' => 'array', 
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }
    public function isRoot()
    {
        return $this->parent_id === null;
    }
    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            if (!$model->path ) {
                if ($model->parent) {
                    $model->path = (!$model->parent->isRoot() ? $model->parent->path . '/' : '') . Str::slug($model->name);
                }
            }
        });
    }
    public function get_file_size()
    {
        if ($this->size){
            
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
            $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;
    
            return number_format($this->size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        }
        else  return null ;
    }
    public function get_date_format()
    {
        if ($this->date)
            return Carbon::parse($this->date)->format('d M Y');
        else
            return null;
    }

    public function transformRelatedFiles(): array
    {
        if (is_array($this->related_files)) {
            return array_map(function ($refnum) {
                // Fetch the file record based on the reference number
                $file = File::where('reference_number',  (string) $refnum)->first();

                return [
                    'refnum' => $refnum,
                    'name'=>  $file ? $file->name : $refnum, 
                    'path' => $file ? $file->path : null, // Get the path if the file exists
                ];
            }, $this->related_files);
        }

        return [];
        

    }
}
