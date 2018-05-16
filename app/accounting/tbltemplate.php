<?php
/**
 * Created by PhpStorm.
 * User: Sultan Ghazi
 * Date: 11/11/2017
 * Time: 12:47 AM
 */

namespace App\accounting;
use Illuminate\Database\Eloquent\Model;

class tbltemplate extends Model
{
    public function scopeFromView($query)
    {
        return $query->from('template_view');
    }
    public function scopeFromViewAttorney($query)
    {
        return $query->from('attorney_view');
    }
}