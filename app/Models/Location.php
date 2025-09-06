<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'location_name'];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function destroyLocation() {
        DB::table('locations')
            ->where('id', $this->id)
            ->delete();
    }
}
