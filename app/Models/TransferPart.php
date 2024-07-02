<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransferPart extends Model
{
    use HasFactory;
    protected $table = "transfer_parts";
    protected $fillable = [
        "from",
        "to",
        "begin",
        "end"
    ];
    protected $casts = [
        "begin" => 'datetime:Y-m-d H:i:s',
        "end" => 'datetime:Y-m-d H:i:s'
    ];

    public function transfer(): BelongsTo {
        return $this->belongsTo(Transfer::class);
    }

    public function from(): BelongsTo {
        return $this->belongsTo(Place::class, "from");
    }

    public function to(): BelongsTo {
        return $this->belongsTo(Place::class, "to");
    }

    public function transferPartTeams(): HasMany {
        return $this->hasMany(TransferPartTeam::class);
    }
}
