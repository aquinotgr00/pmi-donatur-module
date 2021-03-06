<?php

namespace BajakLautMalaka\PmiDonatur;

use Illuminate\Database\Eloquent\Model;

use BajakLautMalaka\PmiDonatur\Jobs\SendEmailStatus;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Donation extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'campaign_id',
        'donator_id', 
        'amount', 
        'pick_method',
        'status', 
        'guest', 
        'anonym',
        'image', 
        'admin_id',
        'invoice_id',
        'address',
        'notes',
        'manual_payment'
    ];

    protected $appends = ['status_text','payment_method_text','pick_method_text','image_url'];

    /**
     * Update donation status
     *
     * @param  int $id
     *
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        return $this->where('id', $id)
                    ->update(['status' => $status]);
    }

    public function donator()
    {
        if (class_exists('BajakLautMalaka\PmiDonatur\Donator')) {
            return $this->belongsTo('BajakLautMalaka\PmiDonatur\Donator');
        }
    }

    public function campaign()
    {
        if (class_exists('BajakLautMalaka\PmiDonatur\Campaign'))
            return $this->belongsTo('BajakLautMalaka\PmiDonatur\Campaign');
    }
    
    public function donationItems()
    {
        if (class_exists('BajakLautMalaka\PmiDonatur\DonationItem')) {
            return $this->hasMany('BajakLautMalaka\PmiDonatur\DonationItem');
        }
    }
    
    public function getStatusTextAttribute()
    {
        $id_status  = $this->status;
        $items      = config('donation.status');
        return (isset($items[$id_status]))? $items[$id_status] : '';
    }

    public function getPaymentMethodTextAttribute()
    {
        if (isset($this->manual_payment)) {
            return ($this->manual_payment)? 'Manual Transfer' : 'Otomatis Transfer';
        }
    }

    public function getPickMethodTextAttribute()
    {
        $id_pick  = $this->pick_method;
        $items    = config('donation.pick_method');
        return (isset($items[$id_pick]))? $items[$id_pick] : '';
    }

    public function getImageUrlAttribute()
    {
        return asset(Storage::url($this->image)); 
    }

    public static function getNextID()
    {
        $nextId = static::whereDate('created_at',\Carbon\Carbon::today())->count();
        ++$nextId;
        return $nextId;
    }
}
