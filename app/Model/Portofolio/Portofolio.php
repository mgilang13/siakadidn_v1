<?php

namespace App\Model\Portofolio;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $guarded = [];

    public function portofolio_type() {
        return $this->belongsTo(\App\Model\Portofolio\PortofolioType::class, 'id_type');
    }

    public function portofolio_app() {
        return $this->hasMany(\App\Model\Portofolio\PortofolioApp::class, 'id_portofolio');
    }

    public function portofolio_image() {
        return $this->hasMany(\App\Model\Portofolio\PortofolioImage::class, 'id_portofolio');
    }
}
