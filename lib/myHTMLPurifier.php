<?php

class myHTMLPurifier extends HTMLPurifier {

	public function createConfig () {
		$config = HTMLPurifier_Config::createDefault();

		// cache dir, just for symfony of course, you can change to another path
		$config->set('Cache.SerializerPath', sfConfig::get('sf_cache_dir'));

		$config->set('HTML.Doctype', 'XHTML 1.0 Strict');

		$config->set('HTML.TidyLevel', 'heavy');

		return $config;
	}

	/**
	 * Will strip all html elements except a, strong, em, p, span, img, li, ul, ol and blockquote
	 */
	public function commonHtml ($value) {
		$config = $this->createConfig();

		// purifier configuration:
		// documentation: http://stackoverflow.com/questions/1320524/how-to-allow-certain-html-tags-in-a-form-field-in-symfony-1-2/1321794#1321794

		$config->set('HTML.DefinitionID', 'commonHtml');
		$config->set('HTML.DefinitionRev', 3);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());
		
		// Allow autolinking
		$config->set('AutoFormat.Linkify', true);

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', 'a,strong,em,br,p,span,img,li,ul,ol,blockquote');

		// these are allowed html attributes, coool!
		$config->set('HTML.AllowedAttributes', 'a.href,a.title,img.src,img.alt,img.title');

		return $this->purify($value, $config);
	}

	/**
	 * Will strip away all elements except p elements
	 */
	public function basicHtml ($value) {
		$config = $this->createConfig();

		$config->set('HTML.DefinitionID', 'basicHtml');
		$config->set('HTML.DefinitionRev', 1);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', 'p');

		return $this->purify($value, $config);
	}

	/**
	 * Will strip away all elements except a,b,strong,i,em elements
	 * Usefull for blocks that's supposed to be only one paragraph
	 */
	public function blockHtml ($value) {
		$config = $this->createConfig();

		$config->set('HTML.DefinitionID', 'blockHtml');
		$config->set('HTML.DefinitionRev', 2);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

		// Allow autolinking
		$config->set('AutoFormat.Linkify', true);

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', 'a,b,br,strong,i,em');
		$config->set('HTML.AllowedAttributes', 'a.href');

		return $this->purify($value, $config);
	}

	/**
	 * Will strip away all htmltags
	 */
	public function noHtml ($value) {
		$config = $this->createConfig();

		$config->set('HTML.DefinitionID', 'noHtml');
		$config->set('HTML.DefinitionRev', 1);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', '');

		return $this->purify($value, $config);
	}
}
