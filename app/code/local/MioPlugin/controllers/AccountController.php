<?php


require_once 'Mage/Customer/controllers/AccountController.php';

class MioPlugin_Writecookielogin_AccountController extends Mage_Customer_AccountController
{
    protected function _loginPostRedirect()
    {
        parent::_loginPostRedirect();
        $this->writeCookie();
    }

    private function writeCookie(){
        $session = $this->_getSession();
        if($session->isLoggedIn()) {
            $dominio = Mage::getStoreConfig('web/cookie/cookie_domain');
            Mage::getSingleton('core/cookie')->set(
                "user_logged", "true", 3600, '/', $dominio, false, false
            );
        }
    }

    private function deleteCookie(){

      Mage::getSingleton('core/cookie')->delete("user_logged");

    }


    public function logoutSuccessAction()
    {
        parent::logoutSuccessAction();
        $this->deleteCookie();
    }

    public function createPostAction()
    {
        parent::createPostAction();
        $this->writeCookie();
    }

}