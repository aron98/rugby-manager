<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    use HasFactory;
    protected $table = "transfers";
    protected $fillable = [
        "transfer_name",
        "driver",
        "license_plate"
    ];

    public function transferParts(): HasMany {
        return $this->hasMany(TransferPart::class);
    }
}
