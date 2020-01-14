<?php
namespace frontend\tests\unit\forms;
use common\fixtures\UserFixture;
use frontend\forms\ResetPasswordForm;

use yii\base\InvalidConfigException;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }
    public function testWrongToken()
    {
        $this->tester->expectThrowable('yii\base\ErrorException', function() {
            new ResetPasswordForm(' ');
        });
        $this->tester->expectThrowable('yii\base\ErrorException', function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }
    public function testCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new ResetPasswordForm($user['password_reset_token']);
        $form->password = 'new-password';
        expect_that($form->validate());
    }
}