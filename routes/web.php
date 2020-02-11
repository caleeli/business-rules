<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/business-rules', 'PackageSkeletonController@index')->name('package.skeleton.index');
    Route::get('business-rules', 'PackageSkeletonController@index')->name('package.skeleton.tab.index');
});
