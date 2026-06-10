<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KlipingDigitalMultiSheetImport implements WithMultipleSheets
{
    protected $sheetsConfig;
    protected $delimiter;

    public function __construct(array $sheetsConfig = [], $delimiter = ';')
    {
        $this->sheetsConfig = $sheetsConfig;
        $this->delimiter = $delimiter;
    }

    /**
     * Define the sheets to be parsed by 0-based index and dynamic heading rows.
     */
    public function sheets(): array
    {
        $sheets = [];
        
        foreach ($this->sheetsConfig as $index => $headingRow) {
            $sheets[$index] = new KlipingDigitalImport($headingRow, $this->delimiter);
        }
        
        return $sheets;
    }
}
