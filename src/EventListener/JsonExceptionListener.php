<?php
// src/EventListener/JsonExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Psr\Log\LoggerInterface;

class JsonExceptionListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // Ajout d'un log pour s'assurer que le listener est appelé
        $this->logger->info('JsonExceptionListener invoked');

        // Capture de l'exception
        $exception = $event->getThrowable();
        $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $message = 'Une erreur interne est survenue.';

        // Gestion des exceptions HTTP spécifiques
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();

            // Personnalisation des messages d'erreur en fonction du code d'erreur
            switch ($statusCode) {
                case 404:
                    $message = 'La page demandée est introuvable.';
                    break;
                case 403:
                    $message = 'Accès interdit.';
                    break;
                case 500:
                    $message = 'Erreur interne du serveur.';
                    break;
                default:
                    $message = $exception->getMessage();  // Utilise le message par défaut de l'exception
                    break;
            }
        }

        // Réponse JSON personnalisée
        $response = new JsonResponse(
            [
                'error' => [
                    'message' => $message,
                    'code' => $statusCode,
                ],
            ],
            $statusCode
        );

        // Remplacement de la réponse par défaut
        $event->setResponse($response);
    }
}
