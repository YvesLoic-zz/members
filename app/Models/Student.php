<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'matricule',
        'class',
        'birthday',
        'birthplace',
        'sex',
        'school_id',
    ];

    /**
     * Cette méthode est utilisée pour avoir l'école d'un eleve.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class, "school_id");
    }

    /**
     * Get all paiement associated to this student
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
