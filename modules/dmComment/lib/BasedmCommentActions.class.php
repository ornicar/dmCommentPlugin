<?php

class BasedmCommentActions extends myFrontModuleActions
{

  public function executeSubmit(sfWebRequest $request)
  {
    $form = new DmCommentForm();

    if ($request->hasParameter($form->getName()))
    {
      $this->bindForm($form, $request);

      if ($form->isValid())
      {
        $form->save();
        $this->getUser()->setFlash('comment_form_valid', true);
        $this->getService('dispatcher')->notify(new sfEvent($this, 'dm_comment.saved', array('comment' => $form->getObject())));

        $this->redirectBack();
      }
    }

    // pass the form to the component
    $request->setAttribute('dm_comment_form', $form);
    // forward to the page
    return $this->forwardToSlug($request->getParameter('dm_page_slug'));
  }

  protected function bindForm(sfForm $form, sfWebRequest $request)
  {
    $data = $request->getParameter($form->getName());

    if($form->isCaptchaEnabled())
    {
      $data = array_merge($data, array('captcha' => array(
        'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
        'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
      )));
    }

    $form->bind($data, $request->getFiles($form->getName()));
  }
}
