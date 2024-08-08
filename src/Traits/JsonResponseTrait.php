<?php

namespace Nerow\Tools\Traits;

// AVAILABLE FOR API CONTROLLER

trait JsonResponseTrait
{
    /**
     * Retourne une réponse formatée.
     *
     * @param  int  $code
     * @param  int  $response_id
     * @param  mixed  $data
     * @return JSON
     */
    private function response(int $code, int $response_id, mixed $data = false)
    {
        $response = [
            'code' => $code,
            'message' => __("json-response.$response_id"),
        ];

        if ($data) {
            $response += $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Retourne un succès.
     *
     * @param  mixed  $data
     * @return JSON
     */
    public function success(mixed $data = false)
    {
        return $this->response(200, 0, $data);
    }

    /**
     * Retourne erreur en cas d'erreur de saisie.
     * 
     * @param  mixed  $data
     * @return JSON
     */
    public function errorBadRequest(mixed $data = false)
    {
        return $this->response(400, 1, $data);
    }

    /**
     * Retourne erreur en cas d'accès non authorisé.
     *
     * @return JSON
     */
    public function errorUnauthorized()
    {
        return $this->response(401, 2);
    }

    /**
     * Retourne erreur en cas d'identifiants invalides.
     *
     * @return JSON
     */
    public function errorInvalidCredantials()
    {
        return $this->response(400, 3);
    }

    /**
     * Retourne erreur en cas de Token expiré.
     *
     * @return JSON
     */
    public function errorTokenExpired()
    {
        return $this->response(401, 4);
    }

    /**
     * Retourne erreur "en cas de model ou requête http introuvable.
     *
     * @return JSON
     */
    public function errorNotFound()
    {
        return $this->response(404, 5);
    }
}