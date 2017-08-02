<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Capsule\Manager as DB;

class Transactions extends Model
{
    protected $table    = 'transactions';
    protected $fillable = ['entry_type', 'transaction_type', 'primary_account_id', 'amount','remarks','secondary_account_id','transaction_date'];

    public static function openingBalance($fromDate, $accountId)
    {     
        $fromDate = date('Y-m-d', strtotime($fromDate . ' -1 day'));

        return Transactions::balanceTill($fromDate,$accountId);   
      
            
    }

    public static function balanceTill($date ,$accountId)
    {   

        $total = 0;

        $date = $date.' 23:59:59';
     
        $accountRecord = Accounts::where('ob_date','<=', $date)
                        ->where('id', $accountId)->first();
        
    	$credit = self::where('transaction_type', 'CREDIT')
                      ->where('primary_account_id', $accountId)
                      ->where('transaction_date', '<=', $date);

        
    	$debit = self::where('transaction_type', 'DEBIT')
                     ->where('primary_account_id', $accountId)
                     ->where('transaction_date', '<=', $date);

        $credit = $credit->sum('amount');
        
        $debit = $debit->sum('amount');
        
        if(!empty($accountRecord))
             $total = $credit  + $accountRecord->ob_amount - $debit;
         else
      	    $total =  $credit - $debit;

        return $total;
            
    }
     

    public static function creditTotal($fromDate, $toDate, $accountId)
    {   
        return self::getTransactionByType('CREDIT', $fromDate, $toDate, $accountId)->sum('amount');
    }

    public static function debitTotal($fromDate, $toDate, $accountId)
    {  
        return self::getTransactionByType('DEBIT', $fromDate, $toDate, $accountId)->sum('amount');
    }

    public static function getTransactionByType($column, $fromDate, $toDate, $accountId)
    {   
       
        if($column == 'CREDIT')
          return self::creditCalculations($accountId, $fromDate, $toDate);
        else
            return self::debitCalculations($accountId, $fromDate, $toDate);
        
    }

    public static function creditCalculations($accountId, $fromDate, $toDate){ 
       
        $toDate = empty($toDate) ? date("Y-m-d H:i:s") : $toDate . ' 23:59:59'; 
        
        $obj = Transactions::where(function ($query) use ($accountId, $fromDate, $toDate){
               $query->where('transaction_type', 'CREDIT')
                ->where('primary_account_id',  $accountId)
                ->where('transaction_date', '>=', $fromDate . ' 00:00:00')
                ->where('transaction_date', '<=', $toDate);

        })->orWhere(function($query) use ($accountId,$fromDate,$toDate){
                $query->where('transaction_type', 'DEBIT')
                ->where('secondary_account_id', $accountId)
                ->where('transaction_date', '>=', $fromDate . ' 00:00:00')
                ->where('transaction_date', '<=', $toDate);  
        });

        return $obj;           
      
    }   

    public static function debitCalculations($accountId,$fromDate,$toDate){
        
        $toDate = empty($toDate) ? date("Y-m-d H:i:s") : $toDate . ' 23:59:59'; 
        
        $obj = Transactions::where(function ($query) use ($accountId,$fromDate,$toDate){
               $query->where('transaction_type', 'DEBIT')
                ->where('primary_account_id',  $accountId)
                ->where('transaction_date', '>=', $fromDate . ' 00:00:00')
                ->where('transaction_date', '<=', $toDate);

        })->orWhere(function($query) use ($accountId,$fromDate,$toDate){
                $query->where('transaction_type', 'CREDIT')
                ->where('secondary_account_id', $accountId)
                ->where('transaction_date', '>=', $fromDate . ' 00:00:00')
                ->where('transaction_date', '<=', $toDate);  
        });

        return $obj;  
     
    }


    function primaryAccount()
    {
        return $this->hasOne(Accounts::class, 'id', 'primary_account_id');   
    }
      
    function secondaryAccount()
    {
        return $this->hasOne(Accounts::class, 'id', 'secondary_account_id');   
    }

    static function closingBalance($toDate, $primaryAccountId)
    {   
        if(empty($toDate))
            $toDate = date('Y-m-d');

        return Transactions::balanceTill($toDate,$primaryAccountId);
    }
}