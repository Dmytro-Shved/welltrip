<?php

Route::get('/', function (){
   return app()->version();
});
