<?php

namespace App\Exports;

//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
//class PoenterUnosExport implements FromCollection
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

use PhpOffice\PhpSpreadsheet\Cell\Cell;


class PoenterUnosExport  extends DefaultValueBinder  implements  FromArray, WithStyles,ShouldAutoSize //,WithColumnFormatting
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

//    /**
//    * @return \Illuminate\Support\Collection
//    */
//    public function collection()
//    {
//        //
//    }

    public function array(): array
    {
        return $this->data;
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
//    public function columnFormats(): array
//    {
//        return [
//            'A' => NumberFormat::FORMAT_TEXT,
//            'B' => NumberFormat::FORMAT_TEXT,
//            'C' => NumberFormat::FORMAT_NUMBER_00,
//        ];
//    }

    public function styles(Worksheet $sheet)
    {
        return [
             1 => ['font' => ['bold' => true]],
            'A'  => ['font' => ['italic' => true]],
            'B'  => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}
