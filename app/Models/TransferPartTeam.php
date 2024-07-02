<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferPartTeam extends Model
{
    use HasFactory;
    protected $table = "transfer_part_teams";
    protected $fillable = [
        "number_of_people",
        "team_id"
    ];

    public function transferPart(): BelongsTo {
        return $this->belongsTo(TransferPart::class);
    }

    public function team(): BelongsTo {
        return $this->belongsTo(Team::class);
    }
}
