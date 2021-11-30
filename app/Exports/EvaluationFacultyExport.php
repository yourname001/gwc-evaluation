<?php

namespace App\Exports;

use App\Models\EvaluationClasses;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Worksheet\Chart;

class EvaluationFacultyExport implements WithCharts
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('evaluation_classes.excel', [
            'evaluationClass' => EvaluationClasses::all()
        ]);
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    public function charts()
    {
        $label      = [new DataSeriesValues('String', 'Worksheet!$B$1', null, 1)];
        $categories = [new DataSeriesValues('String', 'Worksheet!$B$2:$B$5', null, 4)];
        $values     = [new DataSeriesValues('Number', 'Worksheet!$A$2:$A$5', null, 4)];

        $series = new DataSeries(DataSeries::TYPE_PIECHART, DataSeries::GROUPING_STANDARD,
            range(0, \count($values) - 1), $label, $categories, $values);
        $plot   = new PlotArea(null, [$series]);

        $legend = new Legend();
        $chart  = new Chart('chart name', new Title('chart title'), $legend, $plot);

        return $chart;
    }
}
