<?php

namespace App\Exports;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FormSubmissionExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    protected Form $form;
    protected Collection $submissions;
    protected array $fieldLabels;

    public function __construct(Form $form, Collection $submissions)
    {
        $this->form = $form;
        $this->submissions = $submissions;

        // Build dynamic field labels from form definition
        $this->fieldLabels = collect($form->fields ?? [])
            ->pluck('label')
            ->toArray();
    }

    public function collection(): Collection
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        $headers = ['No.', 'Tanggal Pengisian'];

        foreach ($this->fieldLabels as $label) {
            $headers[] = $label;
        }

        // Add any extra keys found in data but not in form fields
        $extraKeys = $this->submissions->flatMap(function ($submission) {
            return array_keys($submission->data ?? []);
        })->unique()->diff($this->fieldLabels)->values()->toArray();

        foreach ($extraKeys as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public function map($submission): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $row = [
            $rowNumber,
            $submission->created_at->format('d/m/Y H:i'),
        ];

        $data = $submission->data ?? [];

        // Fill known fields in order
        foreach ($this->fieldLabels as $label) {
            $row[] = $data[$label] ?? '-';
        }

        // Fill extra keys
        $extraKeys = collect($this->submissions)->flatMap(function ($sub) {
            return array_keys($sub->data ?? []);
        })->unique()->diff($this->fieldLabels)->values()->toArray();

        foreach ($extraKeys as $key) {
            $row[] = $data[$key] ?? '-';
        }

        return $row;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row styling
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '065F46']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Daftar Hadir';
    }
}
