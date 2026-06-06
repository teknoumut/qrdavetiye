<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'make:admin {email?}';

    protected $description = 'Kullanıcıyı admin yap';

    public function handle()
    {
        $email = $this->argument('email');

        if (! $email) {
            $email = $this->ask('Kullanıcı e-posta adresi');
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error('Kullanıcı bulunamadı: '.$email);

            return 1;
        }

        $user->update(['is_admin' => true]);
        $this->info($user->email.' admin yapıldı.');
    }
}
