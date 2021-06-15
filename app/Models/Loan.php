<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'term', 'status', 'interest_rate', 'approved_date', 
    ]; 
    
    public function loansReypayments()
    {
        return $this->hasMany(LoanRepayment::class);
    } 
}
