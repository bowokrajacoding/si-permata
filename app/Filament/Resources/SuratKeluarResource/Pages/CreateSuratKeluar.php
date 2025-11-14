<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use App\Filament\Resources\SuratKeluarResource;
use Filament\Resources\Pages\CreateRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CreateSuratKeluar extends CreateRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $pdf = Pdf::loadView('pdf.surat_keluar', ['surat' => (object) $data]);
        $filePath = 'surat_keluar/' . time() . '.pdf';
        Storage::disk('public')->put($filePath, $pdf->output());
        $data['file_pdf'] = $filePath;

        return $data;
    }
}
