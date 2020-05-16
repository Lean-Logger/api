<?php

class LogoutUserTest extends ApiTestCase
{
    public function testLogoutUser()
    {
        $this->json('POST', route('logout-user'), ['user_id' => $this->jax->getId()], [self::AUTH_HEADER_NAME => self::JAX_LOGIN_TOKEN])
            ->seeStatusCode(200)
        ;
    }
}