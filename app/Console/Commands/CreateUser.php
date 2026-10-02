<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    protected $signature = 'app:create-user {role : Account role: admin or approver}';

    protected $description = 'Create an administrator or approver account';

    public function handle(): int
    {
        $role = (string) $this->argument('role');

        if (! in_array($role, ['admin', 'approver'], true)) {
            $this->error('Role must be either admin or approver.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Name'));
        $email = strtolower(trim((string) $this->ask('Account email')));
        $validator = Validator::make(
            ['name' => $name, 'email' => $email],
            ['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255', 'unique:users,email']],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $password = (string) $this->secret('Password (at least 12 characters)');
        $confirmation = (string) $this->secret('Confirm password');

        if (strlen($password) < 12 || $password !== $confirmation) {
            $this->error('Passwords must match and contain at least 12 characters.');

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $this->info(ucfirst($role)." account created for {$email}.");

        return self::SUCCESS;
    }
}
