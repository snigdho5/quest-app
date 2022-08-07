<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = 'site_setting';
    protected $fillable = ['title', 'logo', 'companylogo', 'login_back', 'flogo', 'favicon', 'footer_text', 'facebook', 'instagram', 'twitter', 'android_app', 'ios_app', 'phone', 'email', 'address', 'google_map', 'ggl_analytic', 'ggl_analytic_ns','app_terms', 'app_policies', 'app_disc', 'app_version_and', 'app_version_ios'];
}
