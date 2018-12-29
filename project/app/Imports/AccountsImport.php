<?php

namespace App\Imports;

use App\Account;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AccountsImport implements ToCollection, withHeadingRow
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function collection(Collection $rows)
    {
        $rows->each(function ($row, $key) {
            Account::create(array_merge([
                'name' => $row['student'],
                'email' => $row['school_e_mailadres'],
            ], $this->data));
        });
    }
}
