<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\UseCases\Auth\RegisterService;
use Illuminate\Console\Command;
//use Symfony\Component\Console\Output\OutputInterface;
//use Symfony\Component\Console\Input\InputInterface;

class VefiryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var RegisterService
     */
    private $service;


    public function __construct(RegisterService $service)
    {
        parent::__construct();


        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        // обновляем через сервис RegisterService, дабы унифицировать в случае развития этого куску кода
        try{
            $this->service->verify($user->id);
        }catch (\DomainException $e){
            // перехватываем исключение, выдергиваем текст сообщения и выводим как нам надо
            $this->error($e->getMessage());
            return false;
        }

        $this->info($email);
        return true;
    }
}
