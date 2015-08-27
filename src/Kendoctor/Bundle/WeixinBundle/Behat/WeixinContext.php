<?php
/**
 * Created by PhpStorm.
 * User: kendoctor
 * Date: 15/8/27
 * Time: 下午8:13
 */

namespace Kendoctor\Bundle\WeixinBundle\Behat;


use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;

class WeixinContext extends RawMinkContext implements KernelAwareContext {


    /**
     * @var  KernelInterface
     */
    protected $kernel;

    /**
     * @Given /^(?:|我)在“(?P<account>(?:[^"]|\\")*)”的微信公众号$/
     */
    public function iAmOnWeixinPublicAccountHome($account)
    {
        $url = $this->locatePath($this->getContainer()->get('router')->generate('kendoctor_weixin_public_account_client_home', array('account' => $account)));
        $this->getSession()->visit($url);
    }

    /**
     *
     * @Then /^(?:|我)应该收到标题为“(?P<account>(?:[^"]|\\")*)”的图文内容$/
     */
    public function iShouldReceivePostWithTitle($title)
    {
        $this->assertSession()->elementContains('css', 'h1,h2,h3,h4', $title);
    }

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getContainer()
    {
        return $this->kernel->getContainer();
    }
}