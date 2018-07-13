<?php
namespace AppBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserAgentSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if(!$event->isMasterRequest()){
            return;
        }
        $this->logger->info('RAAAAAAAAAAAAAAAR');
        $request = $event->getREquest();
        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info('hello There browser:' .$userAgent);
        if(rand(0,100) > 50){
//            $reponse = new Response("Come back later");
//            $event->setResponse($reponse);
        }
//        $request->attributes->set('_controller',function($id){
//           return new Response('Hello ' . $id);
//        });
        $isWindows = stripos($request->headers->get('User-Agent'),'windows');
        if($request->query->get('notWindows')){
            $isWindows = false;
        }
        $request->attributes->set('isWindows',$isWindows);


    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }


}