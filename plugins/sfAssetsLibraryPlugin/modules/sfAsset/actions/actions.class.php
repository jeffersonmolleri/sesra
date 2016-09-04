<?php

require_once sfConfig::get('sf_plugins_dir'). '/sfAssetsLibraryPlugin/modules/sfAsset/lib/BasesfAssetActions.class.php';

class sfAssetActions extends BasesfAssetActions
{
  public function preExecute()
  {
  	$request = $this->getRequest();
  	$files = $request->getFiles('sf_asset');
  	$is_popup = $request->getParameter('is_popup');
  	
    if ($this->getUser()->hasAttribute('popup', 'sf_admin/sf_asset/navigation'))
    {
      $this->getUser()->getAttributeHolder()->remove('popup', null,'sf_admin/sf_asset/navigation');
    }
    
    if ($this->getRequest()->isXmlHttpRequest())
    {
      $this->getRequest()->setParameter('popup', 1);
      $this->getResponse()->setContentType('text/xml');
      $this->getUser()->setAttribute('haslayout', true, 'sf_admin/sf_asset/navigation');
    }
    
    if (!empty($files) && $is_popup > 0)
    {
    	$this->getRequest()->setParameter('popup', 1);
    	$this->getUser()->setAttribute('haslayout', true, 'sf_admin/sf_asset/navigation');
    	$this->getUser()->setAttribute('popup', 1, 'sf_admin/sf_asset/navigation');
    }
  }
  
  public function executeList(sfWebRequest $request)
  {
    $this->getRequest()->setParameter('domtarget', '#folder_list');
    $this->getRequest()->setParameter('folderview', 1);
    $this->getUser()->setAttribute('haslayout', false, 'sf_admin/sf_asset/navigation');
	
    return parent::executeList($request);
  }
}