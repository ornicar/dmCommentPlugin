<?php

/**
 * PluginDmComment form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id$
 */
abstract class PluginDmCommentForm extends BaseDmCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['is_active']);

    $this->changeToHidden('record_model');
    $this->changeToHidden('record_id');

    $this->widgetSchema->setLabel('author_name', 'Name');
    $this->widgetSchema->setLabel('author_website', 'Website');
    $this->widgetSchema->setLabel('author_email', 'Email');
    $this->widgetSchema->setLabel('body', 'Message');
    
    $this->validatorSchema['body']
    ->setOption('required', true)
    ->setMessage('required', 'Please enter a message');

    $this->widgetSchema->setHelp('author_email', 'Your email will never be published');

    $this->changeToEmail('author_email');

    if ($this->isCaptchaEnabled())
    {
      $this->addCaptcha();
    }
  }

  public function addCaptcha()
  {
    $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array(
      'public_key' => sfConfig::get('app_recaptcha_public_key')
    ));

    $this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array(
      'private_key' => sfConfig::get('app_recaptcha_private_key')
    ));
  }

  public function isCaptchaEnabled()
  {
    return sfConfig::get('app_recaptcha_enabled');
  }
}