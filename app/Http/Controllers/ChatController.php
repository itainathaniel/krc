<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    
    public function show(Request $request)
    {
    	$botman = app('botman');

    	$botman->verifyServices(config('services.botman.facebook_app_secret'));

    	$botman->hears('hello', function (BotMan $bot) {
    		$bot->reply('Hello yourself.');
    	});

    	$botman->listen();

    	dd($botman);
    }
}
