<?php

namespace App\Command;

use App\Repository\PlaceRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\EmailService;

#[AsCommand(
    name: 'send-booking-emails',
    description: 'Verifie les voyages',
)]
class SendBookingEmailsCommand extends Command
{
    public function __construct(EmailService $emailService, PlaceRepository $placeRepository)
    {
        parent::__construct();
        $this->emailService = $emailService;
        $this->placeRepository = $placeRepository;
    }

    protected function configure(): void
    {
        $this
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
            ->addOption('send-reminder', null, InputOption::VALUE_NONE, 'Send reminder emails')
            ->addOption('send-departure', null, InputOption::VALUE_NONE, 'Send departure emails')
            ->addOption('send-returned', null, InputOption::VALUE_NONE, 'Send returned emails')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sendReminder = $input->getOption('send-reminder');
        if ($sendReminder) {
            // Code pour envoyer des e-mails de rappel
            $reservations = $this->placeRepository->findPlacesToRemind();
            $templateId = 8; //TemplateId = 8 pour rappel J-1
            foreach ($reservations as $reservation) {
                $userEmail = $reservation['email'];

                $params = array('name'=>'BECLAL', 'USER'=>$userEmail);
                try {
                    $this->emailService->sendTransactionalEmail($userEmail, $templateId, $params);
                } catch (Exception $e) {
                }
            }

            $output->writeln('Sending reminder emails...');
        }

        // Le reste du code pour envoyer les autres e-mails


        /*$arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }*/

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
