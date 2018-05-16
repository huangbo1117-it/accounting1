<?php

namespace App\accounting;

use App\accounting\tblsales;
use Illuminate\Database\Eloquent\Model;

class tblcreditor extends Model
{
    //
    public function saleman()
    {
        return $this->belongsTo('App\accounting\tblsales', 'SaleID', 'SalesID');
    }
}
