<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::view("/", "welcome")->name("home");
Route::get("/language/{language}", [LanguageController::class, "set"])->name(
    "language.set",
);
Route::middleware(["auth", "verified"])->group(function () {});
Route::livewire("/dropzone", "pages::dropzone.index")->name("dropzone");
Route::livewire("/project/{project}", "pages::project.index")->name("project");
Route::livewire("/project/{project}/workbench", "pages::workbench.index")->name(
    "workbench",
);
require __DIR__ . "/settings.php";
