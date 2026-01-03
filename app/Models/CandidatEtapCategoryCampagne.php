<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatEtapCategoryCampagne extends Model
{
    use HasFactory;
    protected $table = 'candidat_etap_category_campagnes';
    protected $primaryKey = 'candidat_etap_category_campagne_id';
    protected $fillable = [
        'candidat_id',
        'campagne_id',
        'etape_id',
        'category_id',
    ];
}
