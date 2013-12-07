<?php
/**
 * ZF2 migration
 *
 * @package    User
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Show user widget View Helper
 *
 * Outputs the user widget
 *
 * @package    User
 */
class UserWidget extends AbstractHelper
{
    /**
     * @var \User_Model_User
     */
    protected $identity;
    /**
     * @var \User_Service_User
     */
    protected $userService;

    /**
     * @param \User_Model_User   $identity
     * @param \User_Service_User $userService
     */
    function __construct($identity, $userService)
    {
        $this->setIdentity($identity);
        $this->setUserService($userService);
    }

    /**
     * Handle the user widget output
     *
     * @return boolean
     */
    public function __invoke()
    {
        $output = '';

        if (!$this->getIdentity()) {
            $loginForm = $this->getUserService()->getForm('login');
            $loginForm->setAction(
                $this->getView()->url(
                    'user',
                    array('controller' => 'index', 'action' => 'login'),
                    true
                )
            );
            $loginForm->setAttrib('class', 'form-vertical');
            $loginForm->getElement('user_name')->setAttrib('class', 'span3');
            $loginForm->getElement('user_password')->setAttrib(
                'class', 'span3'
            );
            $loginForm->setView(new \Zend_View());

            $output .= '<h3>'
                . $this->getView()->translate('heading_user_user_loggedin')
                . '</h3>';

            $output .= $loginForm->render();
        } else {
            $output .= '<h3>' . $this->getView()->translate(
                    'heading_user_user_loggedout'
                ) . '</h3>';

            $output .= '<p><i class="icon-user icon-white"></i> '
                . $this->getIdentity()->getName() . '</p>';

            $output .= '<p><i class="icon-envelope icon-white"></i> '
                . $this->getIdentity()->getEmail() . '</p>';

            $output .= '<p><a href="' . $this->getView()->url(
                    'user',
                    array('controller' => 'index', 'action' => 'logout'),
                    true
                ) . ' " class="btn btn-success">'
                . $this->getView()->translate('action_user_user_logout')
                . '</a></p>';
        }

        return $output;
    }

    /**
     * @return \User_Model_User
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param \User_Model_User $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return \User_Service_User
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @param \User_Service_User $userService
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
    }
}