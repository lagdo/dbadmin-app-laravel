<?php

use Jaxon\App\I18n\Translator;
use Jaxon\Laravel\App\Jaxon;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param string $message
 * @param bool $isError
 *
 * @return Response
 */
function showMessage(string $message, bool $isError): Response
{
    $jaxon = app()->make(Jaxon::class);
    $trans = $jaxon->di()->g(Translator::class);
    $ajaxResponse = $jaxon->ajaxResponse();

    $messageType = $isError ? 'error' : 'warning';
    $messageTitle = $isError ? $trans->trans('Error') : $trans->trans('Warning');
    $ajaxResponse->dialog->title($messageTitle)->$messageType($message);
    return $jaxon->httpResponse();
}
