<?php
/**
 * Test\Unit\src\Utils
 */
namespace Test\Unit\src\Utils;

use Papi\Utils\Mailer;

/**
 * MailerTest
 */
class MailerTest extends \Test\Unit\TestCase
{

    public function testSend()
    {
        $mailer = new Mailer('no-replay@gochipon.co.jp');
        $mailer->addAddress('developers@gochipon.co.jp');
        $mailer->set('Subject', 'subject');
        $mailer->set('Body', 'body');
        $mailer->send();
    }
}
