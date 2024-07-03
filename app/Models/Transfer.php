<?php

namespace App\Models;

use App\TransferType;
use DateTime;
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
        "license_plate",
        "transfer_type"
    ];
    protected $casts = [
        "transfer_type" => TransferType::class
    ];

    public function transferParts(): HasMany {
        return $this->hasMany(TransferPart::class);
    }

    public function getEarliestBeginDate() {
        return $this->transferParts()->get()->sortBy('begin')->first()->begin;
    }
}
