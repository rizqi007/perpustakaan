<?php

namespace App\Filament\Resources\NavigationMenuResource\Pages;

use App\Filament\Resources\NavigationMenuResource;
use App\Models\NavigationMenu;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class ListNavigationMenus extends ListRecords
{
    protected static string $resource = NavigationMenuResource::class;

    protected static string $view = 'filament.pages.navigation-menu-organizer';

    public $selectedParentId = null;

    public function mount(): void
    {
        parent::mount();

        // Default select the first main menu item
        $first = NavigationMenu::whereNull('parent_id')->orderBy('order')->first();
        if ($first) {
            $this->selectedParentId = $first->id;
        }
    }

    public function selectMainMenu($id)
    {
        $this->selectedParentId = $id;
    }

    public function reorderMenus($draggedId, $targetId)
    {
        $dragged = NavigationMenu::find($draggedId);
        $target = NavigationMenu::find($targetId);

        if (!$dragged || !$target || $dragged->parent_id !== $target->parent_id) {
            return;
        }

        $parentId = $dragged->parent_id;
        $items = NavigationMenu::where('parent_id', $parentId)
            ->orderBy('order')
            ->get();

        $draggedIndex = $items->search(fn($item) => $item->id == $draggedId);
        $targetIndex = $items->search(fn($item) => $item->id == $targetId);

        if ($draggedIndex === false || $targetIndex === false) {
            return;
        }

        // Remove item from its current position
        $items->forget($draggedIndex);

        // Slice before and after target
        $before = $items->slice(0, $targetIndex);
        $after = $items->slice($targetIndex);

        // Assemble new order
        $newItems = collect();
        foreach ($before as $item) {
            $newItems->push($item);
        }
        $newItems->push($dragged);
        foreach ($after as $item) {
            $newItems->push($item);
        }

        // Save order to database
        foreach ($newItems as $index => $item) {
            $item->update(['order' => $index + 1]);
        }

        \Filament\Notifications\Notification::make()
            ->title('Urutan menu berhasil diperbarui')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->getCreateMenuAction(),
        ];
    }

    protected function getCreateMenuAction(): Action
    {
        return Action::make('createMenu')
            ->label('Tambah Menu')
            ->modalHeading('Tambah Menu Navigasi')
            ->fillForm(fn (array $arguments) => [
                'parent_id' => $arguments['parent_id'] ?? null,
                'is_active' => true,
                'open_in_new_tab' => false,
            ])
            ->form([
                TextInput::make('label')
                    ->label('Label Menu')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('contoh: Beranda'),

                Select::make('parent_id')
                    ->label('Menu Induk')
                    ->options(fn() => NavigationMenuResource::getParentOptions())
                    ->placeholder('— Tidak ada (Menu Utama) —')
                    ->nullable()
                    ->helperText('Kosongkan untuk membuat Menu Utama, atau pilih untuk sub-menu'),

                TextInput::make('url')
                    ->label('URL / Link')
                    ->maxLength(255)
                    ->placeholder('contoh: /berita atau https://google.com'),

                TextInput::make('route_name')
                    ->label('Nama Route Laravel')
                    ->maxLength(255)
                    ->placeholder('contoh: landing, berita.index'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

                Toggle::make('open_in_new_tab')
                    ->label('Buka di Tab Baru')
                    ->default(false),
            ])
            ->action(function (array $data) {
                // Determine order
                $maxOrder = NavigationMenu::where('parent_id', $data['parent_id'])->max('order') ?? 0;
                $data['order'] = $maxOrder + 1;

                $menu = NavigationMenu::create($data);

                // Auto select if we don't have a selection
                if (is_null($data['parent_id']) && is_null($this->selectedParentId)) {
                    $this->selectedParentId = $menu->id;
                }

                \Filament\Notifications\Notification::make()
                    ->title('Menu berhasil ditambahkan')
                    ->success()
                    ->send();
            });
    }

    protected function getEditMenuAction(): Action
    {
        return Action::make('editMenu')
            ->label('Ubah Menu')
            ->modalHeading('Ubah Menu Navigasi')
            ->before(function (array $arguments) {
                if (empty($arguments['id'] ?? null)) {
                    \Filament\Notifications\Notification::make()
                        ->title('Pilih menu terlebih dahulu')
                        ->body('Klik ikon pensil pada menu yang ingin diubah.')
                        ->warning()
                        ->send();
                    $this->halt();
                }
            })
            ->fillForm(function (array $arguments) {
                if (empty($arguments['id'] ?? null)) {
                    return [];
                }
                $menu = NavigationMenu::find($arguments['id']);
                return $menu ? $menu->toArray() : [];
            })
            ->form([
                TextInput::make('label')
                    ->label('Label Menu')
                    ->required()
                    ->maxLength(255),

                Select::make('parent_id')
                    ->label('Menu Induk')
                    ->options(fn() => NavigationMenuResource::getParentOptions())
                    ->placeholder('— Tidak ada (Menu Utama) —')
                    ->nullable(),

                TextInput::make('url')
                    ->label('URL / Link')
                    ->maxLength(255)
                    ->placeholder('contoh: /berita atau https://google.com'),

                TextInput::make('route_name')
                    ->label('Nama Route Laravel')
                    ->maxLength(255)
                    ->placeholder('contoh: landing, berita.index'),

                Toggle::make('is_active')
                    ->label('Aktif'),

                Toggle::make('open_in_new_tab')
                    ->label('Buka di Tab Baru'),
            ])
            ->action(function (array $data, array $arguments) {
                if (empty($arguments['id'] ?? null)) {
                    return;
                }
                $menu = NavigationMenu::find($arguments['id']);
                if ($menu) {
                    $oldParentId = $menu->parent_id;
                    $menu->update($data);

                    if ($oldParentId !== $data['parent_id']) {
                        $maxOrder = NavigationMenu::where('parent_id', $data['parent_id'])->max('order') ?? 0;
                        $menu->update(['order' => $maxOrder + 1]);

                        if ($this->selectedParentId == $menu->id && !is_null($data['parent_id'])) {
                            $first = NavigationMenu::whereNull('parent_id')->orderBy('order')->first();
                            $this->selectedParentId = $first ? $first->id : null;
                        }
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Menu berhasil diperbarui')
                        ->success()
                        ->send();
                }
            });
    }

    protected function getDeleteMenuAction(): Action
    {
        return Action::make('deleteMenu')
            ->label('Hapus Menu')
            ->modalHeading('Hapus Menu Navigasi')
            ->requiresConfirmation()
            ->modalDescription('Apakah Anda yakin ingin menghapus menu ini? Semua sub-menu di dalamnya juga akan terhapus.')
            ->before(function (array $arguments) {
                if (empty($arguments['id'] ?? null)) {
                    \Filament\Notifications\Notification::make()
                        ->title('Pilih menu terlebih dahulu')
                        ->body('Klik ikon hapus pada menu yang ingin dihapus.')
                        ->warning()
                        ->send();
                    $this->halt();
                }
            })
            ->action(function (array $arguments) {
                if (empty($arguments['id'] ?? null)) {
                    return;
                }
                $menu = NavigationMenu::find($arguments['id']);
                if ($menu) {
                    NavigationMenu::where('parent_id', $menu->id)->delete();
                    $menu->delete();

                    if ($this->selectedParentId == $arguments['id']) {
                        $first = NavigationMenu::whereNull('parent_id')->orderBy('order')->first();
                        $this->selectedParentId = $first ? $first->id : null;
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('Menu berhasil dihapus')
                        ->success()
                        ->send();
                }
            });
    }
}
