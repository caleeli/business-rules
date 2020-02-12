<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/business-rules', 'BusinessRuleController@index')->name('package.skeleton.index');

    Route::get('business-rules/list', 'BusinessRuleController@index')->name('business.rules.tab.index');
    Route::get('business-rules/reports', 'ReportController@index')->name('reports.tab.index');

});
