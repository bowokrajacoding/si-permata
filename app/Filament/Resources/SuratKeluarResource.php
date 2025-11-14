<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeluarResource\Pages;
use App\Models\SuratKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratKeluar::class;
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Surat Keluar';
    protected static ?string $navigationGroup = 'Manajemen Surat';
    protected static ?string $label = 'Surat Keluar';
    protected static ?string $pluralLabel = 'Surat Keluar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nomor')->label('Nomor Surat')->required(),
            Forms\Components\TextInput::make('tujuan')->label('Tujuan Surat')->required(),
            Forms\Components\TextInput::make('perihal')->label('Perihal')->required(),
            Forms\Components\DatePicker::make('tanggal')->label('Tanggal Surat')->required(),
            Forms\Components\Textarea::make('isi')->label('Isi Surat')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')->label('Nomor Surat')->sortable(),
                Tables\Columns\TextColumn::make('tujuan')->label('Tujuan Surat')->sortable(),
                Tables\Columns\TextColumn::make('perihal')->label('Perihal')->sortable(),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('file_pdf')
                    ->label('File PDF')
                    ->formatStateUsing(fn ($state) => $state ? '📄 Unduh' : '-')
                    ->url(fn ($record) => $record->file_pdf ? asset('storage/' . $record->file_pdf) : null)
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKeluar::route('/'),
            'create' => Pages\CreateSuratKeluar::route('/create'),
            'edit' => Pages\EditSuratKeluar::route('/{record}/edit'),
        ];
    }
}
