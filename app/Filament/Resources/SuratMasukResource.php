<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Models\SuratMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;

class SuratMasukResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;

    // 🧭 Ikon & navigasi sidebar
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationGroup = 'Manajemen Surat';
    protected static ?string $navigationLabel = 'Surat Masuk';

    // 🚫 Menghapus huruf “s” di halaman Filament
    protected static ?string $label = 'Surat Masuk';
    protected static ?string $pluralLabel = 'Surat Masuk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nomor')
                ->label('Nomor Surat')
                ->required(),

            Forms\Components\TextInput::make('asal')
                ->label('Asal Surat')
                ->required(),

            Forms\Components\TextInput::make('perihal')
                ->label('Perihal')
                ->required(),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal Surat')
                ->required(),

            Forms\Components\FileUpload::make('lampiran')
                ->label('Lampiran')
                ->directory('surat_masuk')
                ->downloadable()
                ->preserveFilenames()
                ->openable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                    ->label('Nomor Surat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('asal')
                    ->label('Asal Surat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('perihal')
                    ->label('Perihal')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lampiran')
                    ->label('Lampiran')
                    ->formatStateUsing(fn ($state) => $state ? '📎 Lihat / Unduh' : '-')
                    ->url(fn ($record) => $record->lampiran ? asset('storage/' . $record->lampiran) : null)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                Filter::make('bulan')
                    ->form([
                        Forms\Components\Select::make('bulan')
                            ->label('Bulan')
                            ->options(
                                collect(range(1, 12))->mapWithKeys(
                                    fn ($m) => [$m => Carbon::create()->month($m)->translatedFormat('F')]
                                )
                            ),
                    ])
                    ->query(fn ($query, $data) =>
                        $query->when($data['bulan'], fn ($q, $month) => $q->whereMonth('tanggal', $month))
                    ),

                Filter::make('tahun')
                    ->form([
                        Forms\Components\TextInput::make('tahun')
                            ->numeric()
                            ->label('Tahun'),
                    ])
                    ->query(fn ($query, $data) =>
                        $query->when($data['tahun'], fn ($q, $year) => $q->whereYear('tanggal', $year))
                    ),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratMasuk::route('/'),
            'create' => Pages\CreateSuratMasuk::route('/create'),
            'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }
}
