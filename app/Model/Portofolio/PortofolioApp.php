<?php

namespace App\Model\Portofolio;

use Illuminate\Database\Eloquent\Model;

class PortofolioApp extends Model
{
    protected $table = 'portofolio_apps';
    protected $guarded = [];

    public function support_app() {
        return $this->belongsTo(\App\Model\SupportApps::class, 'id_support_app', 'id');
    }
}
