<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday;

use Dojo\HappyBirthday\Clock\ClockService;
use Dojo\HappyBirthday\Customer\Customer;
use Dojo\HappyBirthday\Customer\CustomerRepository;
use Dojo\HappyBirthday\Logger\SimpleLogger;
use Dojo\HappyBirthday\Mailer\Mailer;
use Dojo\HappyBirthday\Mailer\Message;
use Monolog\Logger;

class SendGreetings
{
    /** @var ClockService */
    private $clockService;
    /** @var CustomerRepository */
    private $customerRepository;
    /** @var Mailer */
    private $mailer;
    /** @var Logger */
    private $logger;

    /**
     * SendGreetings constructor.
     *
     * @param ClockService       $clockService
     * @param CustomerRepository $customerRepository
     * @param Mailer             $mailer
     * @param SimpleLogger       $logger
     */
    public function __construct(
        ClockService $clockService,
        CustomerRepository $customerRepository,
        Mailer $mailer,
        SimpleLogger $logger
    )
    {
        $this->clockService = $clockService;
        $this->customerRepository = $customerRepository;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function execute()
    {
        $today = $this->clockService->currentDate();

        $customers = $this->customerRepository->findAllByBirthday($today);

        /** @var Customer $customer */
        foreach ($customers as $customer) {
            $message = new Message();
            $message
                ->withSubject('HappyBirthday')
                ->sendTo($customer->email());
            $this->mailer->send($message);
        }
    }
}
