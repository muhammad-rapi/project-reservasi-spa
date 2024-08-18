<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('name')
    //                 ->placeholder('Nama Kelas...')
    //                 ->rules(['required'])
    //                 ->validationMessages([
    //                     'required' => "Nama Wajib Diisi",
    //                 ])
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('class_code')
    //                 ->placeholder('Kode Kelas...')
    //                 ->rules(['required'])
    //                 ->validationMessages([
    //                     'required' => "Kode Kelas Wajib Diisi",
    //                 ])
    //                 ->maxLength(13),
    //             Forms\Components\TextArea::make('description')
    //                 ->maxLength(255),
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('index')->getStateUsing(
                //     static function (stdClass $rowLoop, HasTable $livewire): string {
                //         return (string) (
                //             $rowLoop->iteration +
                //             ($livewire->recordsPerPage * (
                //                 $livewire->page - 1
                //             ))
                //         );
                //     }
                // ),
                Tables\Columns\TextColumn::make('fullname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('No. HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime()
                    ->sinceTooltip()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->label('Tanggal Diubah')
                //     ->dateTime()
                //     ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions(
                [
                    Tables\Actions\ViewAction::make(),
                    // Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ],
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('fullname'),
                TextEntry::make('address')
                    ->default('-'),
                TextEntry::make('gender'),
                TextEntry::make('phone_number'),
                TextEntry::make('created_at')
                    ->label('Tanggal Bergabung')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('Tanggal Diupdate')
                    ->dateTime(),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            // 'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
