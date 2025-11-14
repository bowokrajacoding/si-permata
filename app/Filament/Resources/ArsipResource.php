<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Carbon\Carbon;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class ArsipResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Arsip Surat';
    protected static ?string $navigationGroup = 'Manajemen Arsip';
    protected static ?string $label = 'Arsip Surat';
    protected static ?string $pluralLabel = 'Arsip Surat';

    public static function table(Table $table): Table
    {
        // Ambil dan gabungkan semua surat masuk & keluar
        $records = collect()
            ->merge(SuratMasuk::all()->map(fn($item) => [
                'tipe' => 'Surat Masuk',
                'nomor' => $item->nomor,
                'asal_tujuan' => $item->asal,
                'perihal' => $item->perihal,
                'tanggal' => $item->tanggal,
                'file' => $item->lampiran ? asset('storage/' . $item->lampiran) : null,
            ]))
            ->merge(SuratKeluar::all()->map(fn($item) => [
                'tipe' => 'Surat Keluar',
                'nomor' => $item->nomor,
                'asal_tujuan' => $item->tujuan,
                'perihal' => $item->perihal,
                'tanggal' => $item->tanggal,
                'file' => $item->file_pdf ? asset('storage/' . $item->file_pdf) : null,
            ]))
            ->sortByDesc('tanggal')
            ->values();

        // Filter manual (karena bukan Query Builder)
        $filters = [
            'tipe' => request('filter_tipe'),
            'bulan' => request('filter_bulan'),
            'tahun' => request('filter_tahun'),
        ];

        $filteredRecords = $records->filter(function ($r) use ($filters) {
            $pass = true;

            if ($filters['tipe']) {
                $pass = $pass && $r['tipe'] === $filters['tipe'];
            }

            if ($filters['bulan']) {
                $pass = $pass && Carbon::parse($r['tanggal'])->month == $filters['bulan'];
            }

            if ($filters['tahun']) {
                $pass = $pass && Carbon::parse($r['tanggal'])->year == $filters['tahun'];
            }

            return $pass;
        });

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipe')
                    ->label('Jenis Surat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor')
                    ->label('Nomor Surat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('asal_tujuan')
                    ->label('Asal / Tujuan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('perihal')
                    ->label('Perihal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->label('File')
                    ->formatStateUsing(fn($state, $record) => $record['file'] ? '📎 Lihat / Unduh' : '-')
                    ->url(fn($record) => $record['file'])
                    ->openUrlInNewTab(),
            ])
            ->filters([
                SelectFilter::make('filter_tipe')
                    ->label('Jenis Surat')
                    ->options([
                        'Surat Masuk' => 'Surat Masuk',
                        'Surat Keluar' => 'Surat Keluar',
                    ]),

                SelectFilter::make('filter_bulan')
                    ->label('Bulan')
                    ->options(
                        collect(range(1, 12))->mapWithKeys(fn($m) => [
                            $m => Carbon::create()->month($m)->translatedFormat('F')
                        ])
                    ),

                Filter::make('filter_tahun')
                    ->form([
                        Forms\Components\TextInput::make('filter_tahun')
                            ->label('Tahun')
                            ->numeric(),
                    ]),
            ])
            ->contentGrid([
                'data' => $filteredRecords,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ArsipResource\Pages\ListArsip::route('/'),
        ];
    }
}
