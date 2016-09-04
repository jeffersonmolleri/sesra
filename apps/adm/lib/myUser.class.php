<?php

class myUser extends sfGuardSecurityUser
{
  public function getId()
  {
    return $this->getGuardUser()->getId();
  }
    
  public function getGroupId()
  {
  	$c = new Criteria();
  	$c->add(sfGuardUserGroupPeer::USER_ID, $this->getId());
  	$group = sfGuardUserGroupPeer::doSelectOne($c);
  	return $group->getGroupId();
  }

  public function signIn($user, $remember = false, $con = null)
  {
    parent::signIn($user, $remember, $con);
    $perms = $this->getAllPermissions();
    if (!empty($perms)) {
      $this->addCredential('logado');
    }
//     $this->setCulture('pt_BR');
  }
  
  public function isValidFile($file)
  {
  	 $continue = false;
  	 
  	 switch (strtolower(substr($file,-3)))
  	 {
  	 	case Informative::PDF:
  	 		$continue = true;
  	 		break;
  	 	case Informative::DOC:
  	 		$continue = true;
  	 		break;
  	 	case Informative::TXT:
  	 		$continue = true;
  	 		break;
  	 	case Informative::CSV:
  	 		$continue = true;
  	 		break;
  	 	case Informative::JPG:
  	 		$continue = true;
  	 		break;
  	 	case Informative::PNG:
  	 		$continue = true;
  	 		break;
  	 	case Informative::GIF:
  	 		$continue = true;
  	 		break;
  	 	case Informative::BMP:
  	 		$continue = true;
  	 		break;
  	 }
  	 
  	 if (strtolower(substr($file,-4)) == Informative::DOCX)
  	 {
  	 	$continue = true;
  	 }
  	 
  	 return $continue;
  }
  
  public function getIconFromType($type)
  {
  	switch ($type)
  	{
  		case sfGuardUser::ADMIN:
  		{
  			return '<img src="/adm/images/admin.gif" alt="Admin" title="Admin" style="width: 20px; height: 20px;" />';
  		}
  		case sfGuardUser::PLATINUM:
  		{
  			return '<img src="/adm/images/platinum.gif" alt="Platinum" title="Platinum" style="width: 16px; height: 30px;" />';
  		}
  		case sfGuardUser::GOLD:
  		{
  			return '<img src="/adm/images/gold.png" alt="Ouro" title="Ouro" style="width: 20px; height: 20px;" />';
  		}
  		case sfGuardUser::SILVER:
  		{
  			return '<img src="/adm/images/silver.png" alt="Silver" title="Silver" style="width: 20px; height: 20px;" />';
  		}
  		default:
  		{
  			return '';
  		}
  	}
  }
  
  public function getFeatures()
  {
    $c = new Criteria();    
	$features_i18n = FeatureI18NPeer::doSelect($c);
	
	$this->features = array();
	foreach ($features_i18n as $feature_i18n)
	{
	  $attr = FeaturePeer::retrieveByPk($feature_i18n->getFeatureId());
	  if ($attr->getIsActive() == true)
	  {
	    $this->features[$attr->getId()] = $feature_i18n->getName();
	  }
	}
	
	return $this->features;
  }
  
  public function getItemsByCategoryId($id)
  {
  	$c = new Criteria();
  	$c->add(CategoryFeaturePeer::CATEGORY_ID, $id);
  	$categories_features = CategoryFeaturePeer::doSelect($c);
  	
  	$features = array();
  	foreach ($categories_features as $category_feature)
  	{
  		$feature = FeatureI18NPeer::retrieveByFeatureID($category_feature->getFeatureId());
  		if(!empty($feature))
  		{
  			$features[] = $feature;
  		}
  	}
  	
  	return $features;
  }
  
  public function getHighlightOnPosition($pos)
  {
  	$c = new Criteria();
  	$c->add(ProductPeer::HIGHLIGHT, $pos);
  	$product = ProductPeer::doSelectOne($c);
  	
  	if(!empty($product))
  	{
  		$prod_array['product'] = $product;
  		$prod_array['i18n'] = ProductI18nPeer::retrieveByProductID($product->getId()); 
  		return $prod_array;
  	}
  	else
  	{
  		return null;
  	}
  }
  
  public function getClientHighlightOnPosition($pos)
  {
  	$c = new Criteria();
  	$c->add(ClientPeer::HIGHLIGHT, $pos);
  	$client = ClientPeer::doSelectOne($c);
  	
  	if(!empty($client))
  	{
  		$cli_array['client'] = $client;
  		$cli_array['i18n'] = ClientI18nPeer::retrieveByClientID($client->getId()); 
  		return $cli_array;
  	}
  	else
  	{
  		return null;
  	}
  }
  
  public function getCategoryHighlightOnPosition($pos)
  {
  	$c = new Criteria();
  	$c->add(CategoryPeer::HIGHLIGHT, $pos);
  	$category = CategoryPeer::doSelectOne($c);
  	
  	if(!empty($category))
  	{
  		$cat_array['category'] = $category;
  		$cat_array['i18n'] = CategoryI18nPeer::retrieveByCategoryID($category->getId()); 
  		return $cat_array;
  	}
  	else
  	{
  		return null;
  	}
  }
  
	public function getNameStripped($string)
	{
		
		$string = str_replace(array('á','à','â','ã','ª'),"a",$string);
        $string = str_replace(array('Á','À','Â','Ã'),"A",$string);
        $string = str_replace(array('é','è','ê'),"e",$string);
        $string = str_replace(array('É','È','Ê'),"E",$string);
        $string = str_replace(array('í','ì'),"i",$string);
        $string = str_replace(array('Í','Ì'),"I",$string);
        $string = str_replace(array('ó','ò','ô','õ','º'),"o",$string);
        $string = str_replace(array('Ó','Ò','Ô','Õ'),"O",$string);
        $string = str_replace(array('ú','ù','û'),"u",$string);
        $string = str_replace(array('Ú','Ù','Û'),"U",$string);
        $string = str_replace("ç","c",$string);
        $string = str_replace("Ç","C",$string);
        $string = str_replace(array('[',']','>','<','}','{',')','(',':',';',',','!','?','*','%','~','^','`','&','#','@'),"_",$string);
        $string = str_replace(" ","_",$string);
        
        return $string;
	}
}