<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class CustomLogin extends BaseLogin
{
	protected string $view = 'filament.pages.auth.login';

	public function getLoginActions(): array
	{
		return $this->getFormActions();
	}
}
