<?php

namespace App\Exports;

use App\Models\EvaluationClasses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EvaluationClassExport implements FromView, WithCharts
{
    // use Exportable;

    public function __construct($evaluationClassID)
    {
        $this->evaluationClassID = $evaluationClassID;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return EvaluationClasses::all();
    } */

    public function headings(): array
    {
        return [
            '',
            'Strongly Agree',
            'Agree',
            'Disagree',
            'Strongly Disagree',
        ];
    }

    public function query()
    {
        return EvaluationClasses::query()->find($this->evaluationClassID);
    }

    public function map($evaluationClassID): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
            [
                $invoice->invoice_number,
                Date::dateTimeToExcel($invoice->created_at),
            ],
            [
                $invoice->lines->first()->description,
            ],
            [
                $invoice->lines->last()->description,
            ]
        ];
    }

    public function charts()
    {
        $evaluationClass = EvaluationClasses::find($this->evaluationClassID);
        $label = [
            new DataSeriesValues('String', 'Worksheet!$B$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$C$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$D$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$E$1', null, 1)
        ];
        $categories = [
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5)
        ];
        $values = [
            new DataSeriesValues('Number', 'Worksheet!$B$2:$B$6', null, 5),
            new DataSeriesValues('Number', 'Worksheet!$C$2:$C$6', null, 5),
            new DataSeriesValues('Number', 'Worksheet!$D$2:$D$6', null, 5),
            new DataSeriesValues('Number', 'Worksheet!$E$2:$E$6', null, 5)
        ];

        $series = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_STANDARD,
            range(0, \count($values) - 1), $label, $categories, $values);
        $plot   = new PlotArea(null, [$series]);

        $legend = new Legend();
        $chart  = new Chart($evaluationClass->class->faculty->fullname('').' Evaluation Chart', new Title($evaluationClass->class->faculty->fullname('').' | '.$evaluationClass->class->course->course_code.' - '.$evaluationClass->class->course->title), $legend, $plot);

        $chart->setTopLeftPosition('G8');
        $chart->setBottomRightPosition('W25');
        // $worksheet->addChart($chart);

        return $chart;
    }

    public function view(): View
    {
        return view('evaluation_classes.excel', [
            'evaluationClass' => EvaluationClasses::find($this->evaluationClassID)
        ]);
    }
}
