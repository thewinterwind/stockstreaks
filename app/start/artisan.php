<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
*/

// update the stock streaks
Artisan::add(new FetchStockHistoryCommand);

// update the stock streaks
Artisan::add(new UpdateStreaksCommand);

// update the stock's trading history
Artisan::add(new UpdateStockHistoryCommand);

// remove whitespace from a table's field
Artisan::add(new RemoveWhitespaceFromFieldCommand);

// used to test something in the application quickly
Artisan::add(new TestAnythingCommand);