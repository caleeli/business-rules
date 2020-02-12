<?php
Route::group(['middleware' => ['auth:api', 'bindings']], function() {
    Route::get('admin/business-rules/fetch', 'BusinessRuleController@fetch')->name('package.skeleton.fetch');
    Route::apiResource('admin/business-rules', 'BusinessRuleController');
});
