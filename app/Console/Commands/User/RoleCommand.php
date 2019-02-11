<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use App\Entity\User;

class RoleCommand extends Command
{
    protected $signature = 'user:role {email} {role}';

    protected $description = 'Set role for user';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle():bool
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try{
            $user->changeRole($role);
        }catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('Role is successfully changed');
        return true;
    }
}
