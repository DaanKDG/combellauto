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
        $rows->each(function ($row, $key) {
           $account = Account::create(array_merge([
                'name' => $row['student'],
                'email' => $row['school_e_mailadres'],
            ], $this->data));
            event(new AccountCreation($account));
        });
    }
}
