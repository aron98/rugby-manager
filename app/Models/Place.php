<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    use HasFactory;
    protected $table = "places";
    protected $fillable = [
        "name"
    ];

    public function transferPartsFrom(): HasMany {
        return $this->hasMany(TransferPart::class, "from");
    }

    public function transferPartsTo(): HasMany {
        return $this->hasMany(TransferPart::class, "to");
    }
}
