<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = "transactions";

    protected $primaryKey = "id";

    public function user() {
        $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id', 'on', 'description', 'amount', 'date', 'location', 'type'
    ];

    public static function _create($request) {
        return Transaction::create([
            'user_id' => auth()->user()->id,
            'on' => $request['on'],
            'description' => $request['description'],
            'date' => $request['date'],
            'type' => $request['type'],
            'location' => $request['location'],
            'amount' => $request['amount']
        ]);
    }

    public static function _getAll($user) {
        return Transaction::where('user_id', $user->id)->latest()->get();
    }

    public static function _delete($transaction) {
        $transaction->delete();
    }

    public static function _getTotal($transaction) {
        return $transaction->sum('amount');
    }
}
