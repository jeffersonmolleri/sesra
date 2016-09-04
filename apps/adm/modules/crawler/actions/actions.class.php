<?php
/**
 * crawler actions.
 *
 * @package    mestrado
 * @subpackage crawler
 * @author     Your name here
 */
class crawlerActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{

	}


	/**
	 * @deprecated
	 * @param sfWebRequest $request
	 * @throws sfError404Exception
	 */
	public function executeSaveBibtex(sfWebRequest $request)
	{
	  throw new sfError404Exception();
		$this->review_id = $request->getParameter('id');
		$this->file = $request->getParameter('file');
		$file = $request->getFiles('file');
		$cnts= file_get_contents($file['tmp_name']);
		$cnts = explode('@',$cnts);
		foreach($cnts as $cnt)
		{
			$cnt = '@' . $cnt;
			$bib = new Structures_BibTex();
			$bib->loadString($cnt);
			$bib->parse();
			foreach ($bib->data as $data)
			{
				$this->saveBibtex($cnt, $data,"",$this->review_id, $request);
			}
		};


		$this->redirect("study/identification?id=" . $this->review_id);
	}

	/**
	 * @deprecated
	 * @param unknown $bib
	 * @param unknown $data
	 * @param string $studyUrl
	 * @param number $sys_id
	 * @param sfWebRequest $request
	 * @throws sfError404Exception
	 */
	public function saveBibtex($bib, $data, $studyUrl = "",$sys_id = 1, sfWebRequest $request)
	{
	  throw new sfError404Exception();
      $study = new Study();
      $base = $request->getParameter('study', 0);
      if (isset($base['base_id']) && $base['base_id'] > 0) {
        $sb = SearchBasePeer::retrieveByPK($base['base_id']);
        $study->setSearchBase($sb);
      }
      if(in_array("abstract", $data))$study->setStudyAbstract($data["abstract"]);

// 		echo $data['year'];
// 		var_dump($data);
// 		die;
// 		$study->setPublicationDate($data["year"]);

		$study->setTitle($data["title"]);
		$study->setSystematicReviewId($sys_id);

		if (!empty($data['url'])) {
		  $study->setUrl($data['url']);
	    }
	    else if (!empty($data['doi'])) {
          $study->setUrl(sprintf('http://dx.doi.org/%s', $data['doi']));
	    }

		$study->setBibtex($bib);
		$study->setCreatedBy($this->getUser()->getId());
		$study->save();
	}
}
