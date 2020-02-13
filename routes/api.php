<?php

Route::group(
    [
        'middleware' => ['auth:api', 'bindings'],
        'as' => 'api.',
    ], function () {

    // Business Rules
    Route::get('business_rules', 'Api\BusinessRuleController@index')->name('business-rules.index')->middleware('can:view-business-rules');
    Route::get('business_rules/{business_rule}', 'Api\BusinessRuleController@show')->name('business-rules.show')->middleware('can:view-business-rules');
    Route::post('business_rules', 'Api\BusinessRuleController@store')->name('business-rules.store')->middleware('can:edit-business-rules');
    Route::put('business_rules/{business_rule}', 'Api\BusinessRuleController@update')->name('business-rules.update')->middleware('can:edit-business-rules');
    Route::delete('business_rules/{business_rule}', 'Api\BusinessRuleController@destroy')->name('business-rules.destroy')->middleware('can:edit-business-rules');

    Route::get('businessrules', 'Api\BusinessRuleController@evaluate')->name('business-rules.evaluate');

});
