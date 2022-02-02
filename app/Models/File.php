<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function fileable()
    {
        return $this->morphTo();
    }
    protected $table = 'files';
    public function getName(){
        $name = explode('.', $this->name);
        return key_exists(1, $name) ? $name[1] : '';

    }
}
