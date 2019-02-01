<?php

namespace App\Imports;

use App\Account;
use App\Events\AccountWasCreated;
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
       $accounts = $rows->filter()->map(function ($row, $key)  {
          return [
                'name' => str_replace( '.' , ' ' , strtok($row['email'] , '@') ) ,
                'email'=> $row['email'],
                'package' => $this->data['package'],
            ];
        })->all();
         
        Account::insert($accounts);

        Account::where('status', 'created')
                 ->get()
                 ->each(function($account, $key) { event(new AccountWasCreated($account)); } );
    }
}
