<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ProductResource\Pages;
use Filament\Tables\Columns\Summarizers\Concerns\BelongsToColumn;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('product_name'),
                BelongsToSelect::make('product_category_id')
                    ->relationship('productCategory', 'name'),
                TextInput::make('short_description'),
                Textarea::make('long_description'),
                TextInput::make('price')
                    ->numeric(),
                TextInput::make('is_variable'),
                TextInput::make('is_grouped'),
                TextInput::make('is_simple'),
                ImageColumn::make('product_image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->searchable()
                    ->sortable(),
                BelongsToColumn::make('productCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('short_description')
                    ->label('Short Description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_variable')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_grouped')
                    ->label('Grouped')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_simple')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('product_image')
                    ->label('Image')
                    ->thumbnail(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
