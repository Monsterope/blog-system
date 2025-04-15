<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:create-user-admin-command {--email=} --{--password=} --{--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option("email");
        $password = $this->option("password");
        $name = $this->option("name");

        if ($email == null || $password == null || $name == null) {
            $this->info('please check arg option.');
        }

        User::create([
            "email" => $email,
            "password" => $password,
            "name" => $name
         ]);
        
    }
}
