<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new BookingsExport, 'bookings.xlsx');
    }
}
