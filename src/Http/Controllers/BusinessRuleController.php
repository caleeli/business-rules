<?php

namespace ProcessMaker\Package\BusinessRules\Http\Controllers;

use ProcessMaker\Http\Controllers\Controller;
use ProcessMaker\Http\Resources\ApiCollection;
use Illuminate\Http\Request;


class BusinessRuleController extends Controller
{
    public function index()
    {
        return view('business-rules::business-rules.index');
    }

}
