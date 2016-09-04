<?php
// auto-generated by sfViewConfigHandler
// date: 2014/02/11 18:40:31
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'SESRA', false, false);
  $response->addMeta('description', 'Software Engineering Systematic Review Automation', false, false);
  $response->addMeta('keywords', 'systematic reviews', false, false);
  $response->addMeta('language', 'pt_BR', false, false);
  $response->addMeta('robots', 'index, follow', false, false);

  $response->addStylesheet('bootstrap.css', '', array ());
  $response->addStylesheet('bootstrap-responsive.css', '', array ());
  $response->addStylesheet('bootstrap-datetimepicker.min.css', '', array ());
  $response->addStylesheet('bootstrap-wysihtml5.css', '', array ());
  $response->addStylesheet('ars.css', '', array ());
  $response->addStylesheet('font-awesome.min.css', '', array ());
  $response->addJavascript('google-code-prettify/prettify.js', '', array ());
  $response->addJavascript('jquery/jquery.js', '', array ());
  $response->addJavascript('jquery/jquery.taconite.js', '', array ());
  $response->addJavascript('jquery/jquery.form.js', '', array ());
  $response->addJavascript('bootstrap/bootstrap.js', '', array ());
  $response->addJavascript('bootstrap/bootstrap-datetimepicker.min.js', '', array ());
  $response->addJavascript('bootstrap/bootstrap-datetimepicker.pt-BR.js', '', array ());


