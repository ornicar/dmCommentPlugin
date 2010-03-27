<?php

class BasedmCommentActions extends myFrontModuleActions
{

  public function executeFormWidget(dmWebRequest $request)
  {
    $form = new DmCommentForm();

    if ($request->hasParameter($form->getName()))
    {
      $data = $request->getParameter($form->getName());

      if($form->isCaptchaEnabled())
      {
        $data = array_merge($data, array('captcha' => array(
          'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
          'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
        )));
      }

      $form->bind($data);

      if ($form->isValid())
      {
        $form->save();

        $this->getUser()->setFlash('comment_form_valid', true);

        $this->getService('dispatcher')->notify(new sfEvent($this, 'dm_comment.saved', array(
          'comment' => $form->getObject()
        )));

        $this->redirectBack();
      }
    }
    
    $this->forms['DmComment'] = $form;
  }
}