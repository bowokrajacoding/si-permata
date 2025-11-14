<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use Filament\Resources\Pages\ListRecords;

class ListArsip extends ListRecords
{
    protected static string $resource = ArsipResource::class;
    protected static ?string $title = 'Arsip Surat';
}
