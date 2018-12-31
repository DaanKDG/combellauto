<?php

namespace App\Imports;

use App\Account;
use App\Events\AccountCreation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class AccountsImport implements ToCollection, withHeadingRow
{
    use Importable;

    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
    
    public function collection(Collection $rows)
    {        
       $accounts = $rows->map(function ($row, $key)  {
          return [
                'name' => mb_convert_encoding($row['student'], "UTF-8", mb_detect_encoding($row['student'], "UTF-8, ISO-8859-1, ISO-8859-15", true)),
                'email'=> $row['school_e_mailadres'],
                'package' => $this->data['package'],
            ];
        })->filter()->all();
         
        Account::insert($accounts);

        Account::where('status', 'created')->get()->each(function($account, $key){
            event(new AccountCreation($account));
        });

    }
}
