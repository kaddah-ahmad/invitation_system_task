<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount()
    {
        $this->currentLocale = Session::get('locale', App::getLocale());
    }

    public function switchLocale($locale)
    {
        if (in_array($locale, config('app.available_locales', ['en']))) {
            Session::put('locale', $locale);
            return redirect(request()->header('Referer', url()->current()));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher', [
            'availableLocales' => config('app.available_locales', ['en']),
        ]);
    }
}
