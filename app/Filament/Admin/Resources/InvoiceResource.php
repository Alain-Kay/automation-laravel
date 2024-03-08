<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Invoice;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\InvoiceResource\Pages;
use App\Filament\Admin\Resources\InvoiceResource\RelationManagers;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                BelongsToSelect::make('customer_id')
                    ->relationship('customer', 'first_name'),
                DatePicker::make('invoice_date'),
                TextInput::make('total_amount')
                    ->numeric(),
                Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'partial' => 'Partial',
                        'overdue' => 'Overdue',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_id'),
                TextColumn::make('invoice_date')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->sortable(),
                TextColumn::make('payment_status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
