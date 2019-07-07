<?php

// DONATOR ROUTES 
Route::group(['prefix' => 'donators', 'as' => 'auth.donators.'], function () {
    Route::post('signin'             , 'DonatorController@signin'                   )->name("signin"               );
    Route::post('signup'             , 'DonatorController@signup'                   )->name("signup"               );
    Route::post('password/reset'     , 'DonatorController@createTokenForgotPassword')->name("token.password.reset" );
    Route::post('password/change'    , 'DonatorController@changePassword'           )->name("token.password.change");
    Route::post('update-profile/{id}', 'DonatorController@updateDonatorProfile'     )->name('update.profile'       );
});

// DONATION ROUTES
Route::group(['prefix' => 'donations', 'as' => 'donations.'], function () {
    Route::post('create', 'DonationApiController@create')->name('create');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get   ('campaigns/all/filter'       , 'CampaignApiController@allFilter'           )->name("campaigns.all.filter"  );
    Route::post  ('campaign'                   , 'CampaignApiController@store'               )->name("campaign.store"        );
    Route::get   ('campaigns/{id}'             , 'CampaignApiController@show'                )->name("campaigns.show"        );
    Route::put   ('campaigns/{id}'             , 'CampaignApiController@update'              )->name("campaigns.update"      );
    Route::delete('campaigns/{id}'             , 'CampaignApiController@delete'              )->name("campaigns.delete"      );
    Route::post  ('campaign/update/finish/{id}', 'CampaignApiController@updateFinishCampaign')->name("campaign.update.finish");
});

//published campaigns
Route::get('campaigns', 'CampaignApiController@index')->name("campaigns.index");