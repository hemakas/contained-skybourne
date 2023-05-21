<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['delivery_id', 'url', 'menu_id', 'title', 'content', 'metakeywords', 'metadesc'];
    
    
    public function menu(){
        return $this->belongsTo('App\Menu', 'menu_id');
    }
}