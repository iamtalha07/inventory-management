<?php

namespace App\Http\Controllers;

use App\AccountFinance;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index() {
        $accounts = AccountFinance::all();
        return view('finance-report.company_finance', compact('accounts'));
    }
}
