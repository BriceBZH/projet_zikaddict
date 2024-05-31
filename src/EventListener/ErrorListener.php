<?php

// namespace App\EventListener;

// use Symfony\Component\HttpKernel\Event\ExceptionEvent;
// use Symfony\Component\HttpKernel\HttpKernelInterface;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Symfony\Component\HttpKernel\Controller\ControllerResolver;

// class ErrorListener
// {
//     private $controllerResolver;
//     private $httpKernel;

//     public function __construct(ControllerResolver $controllerResolver, HttpKernelInterface $httpKernel)
//     {
//         $this->controllerResolver = $controllerResolver;
//         $this->httpKernel = $httpKernel;
//     }

//     public function onKernelException(ExceptionEvent $event)
//     {
//         $exception = $event->getThrowable();

//         if ($exception instanceof NotFoundHttpException) {
//             // Renvoyer vers la méthode error() de DefaultController
//             $request = $event->getRequest();
//             $request->attributes->set('_controller', 'App\Controller\DefaultController::error');
//             $controller = $this->controllerResolver->getController($request);
//             $arguments = $request->attributes->all();
//             $response = call_user_func_array($controller, $arguments);
//             $event->setResponse($response);
//         }
//     }
// }
